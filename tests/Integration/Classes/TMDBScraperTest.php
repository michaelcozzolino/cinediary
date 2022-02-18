<?php


namespace Tests\Integration\Classes;

use App\Classes\TMDBScraper;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Setting;
use App\Models\User;
use Tests\TestCase;

class TMDBScraperTest extends TestCase {

    private TMDBScraper $TMDBSCraper;
    private const SEARCH_QUERY = 'mission impossible';
    private const FAKE_QUERY = 'qwertyabc_fake_query';
    private string $moviesTableName;
    private string $seriesTableName;
    private Movie $blankMovie;
    private Series $blankSeries;

    public function setUp(): void {
        parent::setUp();
        $this->TMDBSCraper = new TMDBScraper(TMDBScraper::DEFAULT_API_KEY);
        $this->blankMovie = new Movie();
        $this->blankSeries = new Series();
        $this->moviesTableName = $this->blankMovie->getTable();
        $this->seriesTableName = $this->blankSeries->getTable();

    }


    /**
     * @test
     *
     */
    public function default_api_key_is_used() {

        $this->assertEquals(TMDBScraper::DEFAULT_API_KEY, (new TMDBScraper(null))->getApiKey());

        $user = $this->signIn()->user;
        $u = User::first();

        $user->settings()->update([
            'TMDBApiKey' => null,
        ]);

        $this->assertEquals('7bff79e50491c5c1166a4497606d5ad3', (new TMDBScraper(null))->getApiKey());
    }

    /**
     * @test
     *
     */
    public function user_api_key_is_used() {
        $user = $this->signIn()->user;

        $user->settings()->update([
            'TMDBApiKey' => '7bff79e50491c5c1166a4497606d5ad3',
        ]);
        $this->assertEquals('7bff79e50491c5c1166a4497606d5ad3', (new TMDBScraper(null))->getApiKey());
    }

    /** @test */
    public function api_key_is_valid(){
        $this->assertTrue($this->TMDBSCraper->isApiKeyValid());
    }

    /** @test */
    public function api_key_is_not_valid(){
        $this->TMDBSCraper->setApiKey("NOT_VALID_API_KEY");
        $this->assertFalse($this->TMDBSCraper->isApiKeyValid());
    }

    /** @test */
    public function search_returns_zero_or_more_results(){
        $this->assertGreaterThanOrEqual(1, count($this->TMDBSCraper->searchMovies(self::SEARCH_QUERY)));
        $this->assertEquals(0, count($this->TMDBSCraper->searchMovies(self::FAKE_QUERY)));
        $this->assertGreaterThanOrEqual(1, count($this->TMDBSCraper->searchSeries(self::SEARCH_QUERY)));
        $this->assertEquals(0, count($this->TMDBSCraper->searchSeries(self::FAKE_QUERY)));
    }

    /** @test */
    public function it_can_collect_screenplays(){
        $searchResults = $this->TMDBSCraper->search(self::SEARCH_QUERY);

        $this->assertContainsOnlyInstancesOf(\Illuminate\Support\Collection::class, $searchResults);

        $this->assertArrayHasKey($this->moviesTableName, $searchResults);
        $this->assertArrayHasKey($this->seriesTableName, $searchResults);

        $movies = $searchResults[$this->moviesTableName];
        $series = $searchResults[$this->seriesTableName];

        $this->assertGreaterThanOrEqual(1, count($movies));
        $this->assertGreaterThanOrEqual(1, count($series));

        $firstMovie = $movies->first();
        $keys = ['id', 'title', 'posterPath'];

        foreach ($keys as $key)
            $this->assertArrayHasKey($key, $firstMovie);

    }

    /** @test */
    public function it_can_translate_a_screenplay(){
        $movies = $this->TMDBSCraper->search(self::SEARCH_QUERY)['movies'];
        $series = $this->TMDBSCraper->search(self::SEARCH_QUERY)['series'];

        $firstMovie = $movies->first();
        $firstSeries = $series->first();

        $movieTranslations = $this->TMDBSCraper->translate($firstMovie['id'], $this->blankMovie, $this->availableLanguages);
        $seriesTranslations = $this->TMDBSCraper->translate($firstSeries['id'], $this->blankSeries);

        $keys = ['id', 'backdropPath', 'posterPath', 'overview', 'title', 'originalTitle', 'releaseDate', 'genre'];
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $movieTranslations);

            if( is_array($movieTranslations[$key])) {
                $translationsAttributes = array_keys($movieTranslations[$key]);

                foreach ($translationsAttributes as $translationsAttribute)
                    $this->assertTrue(in_array($translationsAttribute, $this->availableLanguages));

            }
        }




            //do it also for tv series
    }

    /** @test */
    public function it_cannot_translate_a_screenplay(){

        $this->assertNull($this->TMDBSCraper->translate(-1, $this->blankMovie));
        $this->assertNull($this->TMDBSCraper->translate(-1, $this->blankSeries));
    }






}
