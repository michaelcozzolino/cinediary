<?php

declare(strict_types=1);

namespace Tests\Services\Language;

use App\Exceptions\Language\LanguageNotFoundException;
use App\Repositories\UserSettingRepository;
use App\Services\Language\Switcher;
use Auth;
use Illuminate\Support\Facades\Session;
use Mockery;
use Tests\TestCase;

class SwitcherTest extends TestCase
{
    protected Mockery\MockInterface $settingRepositoryMock;

    protected Switcher              $switcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->settingRepositoryMock = Mockery::mock(UserSettingRepository::class);

        $this->switcher = new Switcher($this->settingRepositoryMock);
    }

    /** @test */
    public function it_switches_language_when_user_is_not_logged(): void
    {
        $requestedLanguage = 'it';

        Session::shouldReceive('put')->once()->with('locale', $requestedLanguage);

        Auth::shouldReceive('id')->once()->andReturn(null);

        $this->settingRepositoryMock->shouldReceive('changeDefaultLanguageByUser')
                                ->never();

        $this->switcher->switchTo($requestedLanguage, ['en', $requestedLanguage]);
    }

    /** @test */
    public function it_switches_language_when_user_is_logged(): void
    {
        $userId = 1;
        $requestedLanguage = 'it';

        Session::shouldReceive('put')->once()->with('locale', $requestedLanguage);

        Auth::shouldReceive('id')->once()->andReturn($userId);

        $this->settingRepositoryMock->shouldReceive('changeDefaultLanguageByUser')
                                ->once()
                                ->with($userId, $requestedLanguage);

        $this->switcher->switchTo($requestedLanguage, ['en', $requestedLanguage]);
    }

    /** @test */
    public function it_does_not_switch_language_when_requested_language_is_not_found(): void
    {
        $requestedLanguage = 'fr';

        $this->expectException(LanguageNotFoundException::class);

        $this->switcher->switchTo($requestedLanguage, ['en', 'it']);
    }
}
