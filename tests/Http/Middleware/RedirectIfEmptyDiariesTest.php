<?php

namespace Tests\Http\Middleware;

use App\Http\Middleware\RedirectIfEmptyDiaries;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class RedirectIfEmptyDiariesTest extends TestCase
{
    use RefreshDatabase;

    private $middleware;

    public function setUp(): void
    {
        parent::setUp();
        $this->signIn();
        $this->middleware = new RedirectIfEmptyDiaries();
    }

    /** @test */
    public function it_redirects_a_user_to_the_search_page_if_every_diary_he_owns_is_empty()
    {
        $request = Request::create(route('dashboard'), 'GET');
        $response = $this->middleware->handle($request, function () {});

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('search.create'), $response->headers->get('Location'));
        $this->assertEquals($this->middleware::ERROR_MESSAGE, session('message'));
    }

    /** @test */
    public function it_does_not_redirect_a_user_to_the_search_page_if_at_least_a_diary_he_owns_is_not_empty()
    {
        $movie = createMovies(1)[0];
        $movie->track($this->diaries['watched']);
        $dashboardResponse = $this->get(route('dashboard'));

        $request = Request::create(route('dashboard'), 'GET');
        $response = $this->middleware->handle($request, function () use ($dashboardResponse) {
            return $dashboardResponse;
        });

        $response->assertOk();
    }
}
