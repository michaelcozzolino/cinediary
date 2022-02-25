<?php

namespace Tests\Integration\Http\Controllers;

use App\Models\Movie;
use App\Models\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

class DashboardControllerTest extends \Tests\TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
        $movies = [];
        $series = [];
        $movies[] = Movie::factory()
            ->create(['title' => 'a', 'genre' => 'action'])
            ->addToDiary($this->diaries['watched']);
        $movies[] = Movie::factory()
            ->create(['title' => 'b', 'genre' => 'action'])
            ->addToDiary($this->diaries['watched']);
        $movies[] = Movie::factory()
            ->create(['title' => 'c', 'genre' => 'action'])
            ->addToDiary($this->diaries['watched']);
        $movies[] = Movie::factory()
            ->create(['title' => 'c', 'genre' => 'adventure'])
            ->addToDiary($this->diaries['watched']);
        $movies[] = Movie::factory()
            ->create(['title' => 'c', 'genre' => 'adventure'])
            ->addToDiary($this->diaries['watched']);

        $series[] = Series::factory()
            ->create(['title' => 'x', 'genre' => 'action'])
            ->addToDiary($this->diaries['watched']);
        $series[] = Series::factory()
            ->create(['title' => 'y', 'genre' => 'adventure'])
            ->addToDiary($this->diaries['watched']);
        $series[] = Series::factory()
            ->create(['title' => 'z', 'genre' => 'comedy'])
            ->addToDiary($this->diaries['watched']);
    }

    /**
     * @test
     *
     */
    public function it_shows_the_latest_maximum_4_movies()
    {
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Home/Dashboard/Index')
                    ->has('lastWatchedScreenplaysData.movies', 4),
            );
    }

    /**
     * @test
     *
     */
    public function it_shows_the_latest_maximum_4_series()
    {
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Home/Dashboard/Index')
                    ->has('lastWatchedScreenplaysData.series', 3),
            ); //there are only 3 series in the watched series diary
    }

    /**
     * @test
     *
     */
    public function it_shows_the_correct_letters_bar_chart()
    {
        $totalLetters = 27; // symbols are includes
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Home/Dashboard/Index')
                    ->hasAll([
                        'chartData.lettersBarChart.movies' => $totalLetters,
                        'chartData.lettersBarChart.series' => $totalLetters,
                    ])
                    ->whereAll([
                        'chartData.lettersBarChart.movies.A' => 1,
                        'chartData.lettersBarChart.movies.B' => 1,
                        'chartData.lettersBarChart.movies.C' => 3,
                        'chartData.lettersBarChart.series.X' => 1,
                        'chartData.lettersBarChart.series.Y' => 1,
                        'chartData.lettersBarChart.series.Z' => 1,
                    ])
                    ->etc(),
            );
    }

    /**
     * @test
     *
     */
    public function it_shows_the_correct_watched_screenplays_percentage_chart()
    {
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Home/Dashboard/Index')
                    ->whereAll([
                        'chartData.watchedScreenplaysPercentageChart.movies' => 5,
                        'chartData.watchedScreenplaysPercentageChart.series' => 3,
                    ])
                    ->etc(),
            );
    }

    /**
     * @test
     *
     */
    public function it_shows_the_correct_watched_genres_percentage_chart()
    {
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Home/Dashboard/Index')
                    ->whereAll([
                        'chartData.watchedGenresPercentageChart.action' => 4,
                        'chartData.watchedGenresPercentageChart.adventure' => 3,
                        'chartData.watchedGenresPercentageChart.comedy' => 1,
                    ])
                    ->etc(),
            );
    }
}
