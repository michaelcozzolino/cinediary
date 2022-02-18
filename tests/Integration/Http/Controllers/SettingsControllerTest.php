<?php


namespace Tests\Integration\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

class SettingsControllerTest extends \Tests\TestCase {

    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->signIn();

    }

    /**
     * @test
     *
     */
    public function it_can_show_the_user_settings() {
        $this->assertDatabaseHas('settings', [
            'user_id' => $this->user->id,
            'TMDBApiKey' => null,
            'adultContent' => 0,
            'defaultLanguage' => config('app.locale')
        ]);

        $this->get(route('settings.index'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Settings/Index')
                ->has('settings')
                ->whereAll([
                    'settings.TMDBApiKey' => null,
                    'settings.adultContent' => 0,
                    'settings.defaultLanguage' => config('app.locale')
                ]));
    }


    /**
     * @test
     * @dataProvider getSettingsData
     */
    public function it_can_update_the_user_settings_if_data_are_valid($settings) {
        $this->assertDatabaseHas('settings', [
            'user_id' => $this->user->id,
        ]);

        $this->get(route('settings.index'))->assertOk();
        $this->patch(route('settings.update'), $settings)
            ->assertRedirect(route('settings.index'));
        $this->assertDatabaseHas('settings', array_merge([
            'user_id' => $this->user->id,
        ], $settings));


    }

    public function getSettingsData(){

        return [
            [
                [
                    'TMDBApiKey' => null,
                    'adultContent' => 0,
                ]
            ],
            [
                [
                    'TMDBApiKey' => '7bff79e50491c5c1166a4497606d5ad3',
                    'adultContent' => 1,
                ]
            ],

        ];

    }

    /**
     * @test
     *
     */
    public function it_cannot_update_the_user_settings_if_data_are_not_valid() {
        $this->assertDatabaseHas('settings', [
            'user_id' => $this->user->id,
        ]);

        $this->get(route('settings.index'))->assertOk();
        $this->patch(route('settings.update'), [
            'TMDBApiKey' => 'NOT_A_VALID_API_KEY',
            'adultContent' => 0,
        ])
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasErrors('TMDBApiKey');

    }

}
