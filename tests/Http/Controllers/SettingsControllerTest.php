<?php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

class SettingsControllerTest extends \Tests\TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /**
     * @test
     */
    public function it_can_show_the_user_settings()
    {
        $this->assertDatabaseHas('settings', [
            'user_id' => $this->user->id,
            'adultContent' => 0,
            'defaultLanguage' => config('app.locale'),
        ]);

        $this->get(route('settings.index'))->assertInertia(
            fn (Assert $page) => $page
                ->component('Settings/Index')
                ->has('settings')
                ->whereAll([
                    'settings.adultContent' => 0,
                    'settings.defaultLanguage' => config('app.locale'),
                ]),
        );
    }

    /**
     * @test
     * @dataProvider getSettingsData
     */
    public function it_can_update_the_user_settings_if_data_are_valid($settings)
    {
        $this->assertDatabaseHas('settings', [
            'user_id' => $this->user->id,
        ]);

        $this->get(route('settings.index'))->assertOk();
        $this->patch(route('settings.update'), $settings)->assertRedirect(route('settings.index'));
        $this->assertDatabaseHas(
            'settings',
            array_merge(
                [
                    'user_id' => $this->user->id,
                ],
                $settings,
            ),
        );
    }

    public function getSettingsData()
    {
        return [
            [
                [
                    'adultContent' => 0,
                ],
            ],
            [
                [
                    'adultContent' => 1,
                ],
            ],
        ];
    }
}
