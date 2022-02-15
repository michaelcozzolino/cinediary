<?php


namespace Tests\Integration\Traits;

use App\Classes\TMDBScraper;
use App\Models\Diary;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\Assert;
use Tmdb\Model\Collection;

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
        $this->get(route('search.index'));
        $response = $this->post(route('diaries.movies.store', ['diary' => $this->diaries['watched']]), [
            $invalidData
        ]);

        $response->assertRedirect(route('search.index'))
            ->assertSessionHasErrors($invalidFields);

        $this->assertEquals(0, Movie::whereId($invalidData['screenplayId'])->count());

    }

    /** @test */
    public function it_can_store_a_screenplay_if_it_does_not_exist_in_database(){
        $movieId = 353081; // taken from TMDB
        $this->get(route('search.index'));
        $response = $this->post(route('diaries.movies.store', ['diary' => $this->diaries['watched']]), [
            'screenplayId' => $movieId
        ]);

        $response->assertRedirect(route('search.index'));

        $this->assertEquals(1, Movie::whereId($movieId)->count());

    }

    /** @test */
    public function it_cannot_store_a_screenplay_because_it_does_not_exists_in_tmbd_api(){
        $movieId = 0;
        $this->get(route('search.index'));
        $response = $this->post(route('diaries.movies.store', ['diary' => $this->diaries['watched']]), [
            'screenplayId' => $movieId,
        ]);

        $response->assertRedirect(route('search.index'));

        $response->assertSessionHas('message', 'The requested ' . Movie::getTableName() . ' does not exist!');
        $this->assertEquals(0, Movie::whereId($movieId)->count());


    }




    /** @test */
    public function it_can_attach_a_screenplay_to_an_existing_diary(){
        $movieId = 353081; // taken from TMDB
        $this->get(route('search.index'));
        $response = $this->post(route('diaries.movies.store', ['diary' => $this->diaries['watched']]), [
            'screenplayId' => $movieId
        ]);

        $response->assertRedirect(route('search.index'));

        $this->assertEquals(1, $this->diaries['watched']->movies()->whereId($movieId)->count());

    }

    /* tests related to destroy() */

    /** @test */
    public function it_can_detach_a_screenplay_from_an_existing_diary(){
        $this->get(route('diaries.movies.index', [
            'diary' => $this->diaries['watched']
        ]));
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
