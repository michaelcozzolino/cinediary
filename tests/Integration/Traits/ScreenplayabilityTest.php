<?php


namespace Tests\Integration\Traits;

use App\Classes\TMDBScraper;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ScreenplayabilityTest extends TestCase
{
    use RefreshDatabase;
    private Movie $movie;
    private $TMDBScraper;
    private $movies;
    private $maxScreenplaysPerPage;

    protected function setUp(): void {
        parent::setUp();


        $this->TMDBScraper = new TMDBScraper(TMDBScraper::DEFAULT_API_KEY);
        $this->signIn();
        $this->movie = Movie::factory()->create(['id' => 1]);
        $this->movie->addToDiary($this->diaries['favourite']);

        $this->maxScreenplaysPerPage = config('cinediary.pagination_limit');
        $this->movies = createMovies(1 + $this->maxScreenplaysPerPage * 2);
        //total movies in watched diary is 1 + 1 + 40
        $this->diaries['watched']->movies()->syncWithoutDetaching($this->movies->pluck('id'));


    }

    /* tests related to index() */

    /**
     * @test
     * @dataProvider getIndexPaginationData()
     * */
    public function it_can_paginate_a_screenplays_collection($currentPage, $screenplaysData){
        $response = $this->get(route('diaries.movies.index', [
            'diary' => $this->diaries['watched'],
            'page' => $currentPage
        ]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Diaries/Show')
                ->hasAll($screenplaysData)
                ->where('diary.id', $this->diaries['watched']->id));

    }

    public function getIndexPaginationData(){
        return [
            [
                'page' => 1,
                [
                    'screenplays.movies.data' => $this->maxScreenplaysPerPage,
                    'diary'
                ]
            ],
            [
                'page' => 2,
                [
                    'screenplays.movies.data' => $this->maxScreenplaysPerPage,
                    'diary'
                ]
            ],
            [
                'page' => 3,
                [
                    'screenplays.movies.data' => 2,
                    'diary'
                ]
            ]
        ];
    }

    /* tests related to store() */

    /** @test
     * @dataProvider \Tests\TestCase::getInvalidScreenplayIds()
     */
    public function it_cannot_store_a_screenplay_because_data_is_invalid($invalidData, $invalidFields){
        $response = $this->post(route('diaries.movies.store', ['diary' => $this->diaries['watched']]), [
            $invalidData
        ]);
        $response->assertRedirect()
            ->assertSessionHasErrors($invalidFields);

        $this->assertEquals(0, Movie::whereId($invalidData['screenplayId'])->count());

    }

    /** @test */
    public function it_can_store_a_screenplay_if_it_does_not_exist_in_database(){
        $movieId = 353081; // taken from TMDB
        $response = $this->post(route('diaries.movies.store', ['diary' => $this->diaries['watched']]), [
            'screenplayId' => $movieId
        ])
            ->assertRedirect();

        $this->assertEquals(1, Movie::whereId($movieId)->count());

    }

    /** @test */
    public function it_cannot_store_a_screenplay_because_it_does_not_exists_in_tmbd_api(){
        $movieId = 0;

        $response = $this->post(route('diaries.movies.store', ['diary' => $this->diaries['watched']]), [
            'screenplayId' => $movieId,
        ])
            ->assertRedirect()
            ->assertSessionHas('message', 'The requested ' . Movie::getTableName() . ' does not exist!');

        $this->assertEquals(0, Movie::whereId($movieId)->count());

    }




    /** @test */
    public function it_can_attach_an_existing_screenplay_to_an_existing_diary(){
        //id from TMDB (important: [no mock] it uses the tmdb api to scrape it and save it into the database)
        $screenplayId = 634649;
        $this->get(route('diaries.movies.index', [
            'diary' => $this->diaries['watched']
        ]))->assertOk();

        $response = $this->post(route('diaries.movies.store', [
            'diary' => $this->diaries['favourite'],

        ]), compact('screenplayId'))
            ->assertRedirect(route('diaries.movies.index', [
                'diary' => $this->diaries['watched']
            ]));
        $this->assertEquals(1, $this->diaries['favourite']->refresh()->movies()->whereId($screenplayId)->count());

    }

    /* tests related to destroy() */

    /** @test */
    public function it_can_detach_a_screenplay_from_an_existing_diary(){
        $this->get(route('diaries.movies.index', [
            'diary' => $this->diaries['watched']
        ]))->assertOk();
        $response = $this->delete(route('diaries.movies.destroy', [
            'diary' => $this->diaries['watched'],
            'movie' => $this->movie
        ]))
            ->assertRedirect(route('diaries.movies.index', [
                'diary' => $this->diaries['watched']
            ]))
            ->assertSessionHas('message');

        $this->assertFalse($this->movie->existsInDiary($this->diaries['watched']));
        $this->assertFalse($this->movie->existsInDiary($this->diaries['favourite']));

    }

}
