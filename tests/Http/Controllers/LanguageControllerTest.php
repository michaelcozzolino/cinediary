<?php

declare(strict_types=1);

namespace Tests\Http\Controllers;

use App\Helpers\ModelHelper;
use App\Models\UserSetting;
use App\Providers\RouteServiceProvider;
use Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected MockInterface $userSettingService;

    protected MockInterface $userService;

    protected const AVAILABLE_LOCALES = ['en', 'it', 'fr'];

    protected readonly string $settingTableName;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = Mockery::mock(UserService::class);
        $this->userSettingService = Mockery::mock(UserSettingService::class, [$this->userService]);

        $this->signIn();
        $this->settingTableName = ModelHelper::getTable(UserSetting::class);

        Config::set('app.available_locales', self::AVAILABLE_LOCALES);
    }

    /** @test */
    public function it_redirects_to_homepage_if_language_does_not_exist()
    {
        Log::shouldReceive('info')->once();
        $response = $this->put(route('language.update', ['language' => 'a language']));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test */
    public function it_changes_language_for_logged_user(): void
    {
        $this->assertAuthenticated();
        $this->user->settings->update(['defaultLanguage' => self::AVAILABLE_LOCALES[0]]);

        Log::shouldReceive('info')->twice();

        $newLanguage = self::AVAILABLE_LOCALES[1];
        $this->put(route('language.update', ['language' => $newLanguage]))
             ->assertRedirect();

        $this->assertDatabaseHas($this->settingTableName, [
            'user_id' => $this->user->id,
            'defaultLanguage' => $newLanguage,
        ]);

        self::assertSame($newLanguage, Session::get('locale'));
    }

    /** @test */
    public function it_changes_language_for_not_logged_user()
    {
        Auth::logout();
        $this->assertGuest();

        Log::shouldReceive('info')->twice();

        $newLanguage = self::AVAILABLE_LOCALES[2];
        $this->put(route('language.update', ['language' => $newLanguage]))
             ->assertRedirect();

        $this->assertDatabaseMissing($this->settingTableName, [
            'user_id' => $this->user->id,
            'defaultLanguage' => $newLanguage,
        ]);

        self::assertSame($newLanguage, Session::get('locale'));
    }
}
