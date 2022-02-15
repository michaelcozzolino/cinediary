<?php


namespace Tests\Integration\Http\Controllers;

use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;

class SearchControllerTest extends \Tests\TestCase {

    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->signIn();
    }

    /**
     * @test
     *
     */
    public function the_search_form_is_shown_without_last_search() {
        session()->remove(SearchController::SEARCH_SESSION_DATA_KEY);
        $this->assertNull(session(SearchController::SEARCH_SESSION_DATA_KEY));

        $this->get(route('search.create'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Search')
                ->missingAll([
                    'screenplays',
                    'lastQuery',
                    'alreadyInDiariesScreenplaysIds',
                ])->etc()

            );
    }

    /**
     * @test
     *
     */
    public function it_can_search_if_form_data_are_valid() {
        $this->post(route('search.make', [
            'query' => 'mission impossible'
        ]))
            ->assertRedirect(route('search.index'))
            ->assertSessionHas([SearchController::SEARCH_SESSION_DATA_KEY, 'lastQuery']);


    }

    /**
     * @test
     *
     */
    public function it_redirects_to_the_search_form_if_form_data_are_valid() {
        $this->get(route('search.create'));
        $response = $this->post(route('search.make'))
            ->assertRedirect(route('search.create'))
            ->assertSessionHasErrors('query');

    }

    /**
     * @test
     *
     */
    public function the_search_form_is_shown_with_last_search() {
        $query = 'mission impossible';
        $this->post(route('search.make', compact('query')));

        $this->get(route('search.index'))
            ->assertSessionHas([SearchController::SEARCH_SESSION_DATA_KEY, 'lastQuery'])
            ->assertInertia(fn (Assert $page) => $page
                ->component('Search')
                ->hasAll([
                    'screenplays',
                    'lastQuery',
                    'alreadyInDiariesScreenplaysIds',
                ])
                ->where('lastQuery', $query)
                ->etc()

            );


    }


}
