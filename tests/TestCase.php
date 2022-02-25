<?php

namespace Tests;

use App\Models\Diary;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected $user;
    protected array $diaries;
    protected array $availableLanguages;

    protected function setUp(): void
    {
        parent::setUp();

        $this->availableLanguages = config('app.available_locales');
    }

    public function signIn(User $user = null)
    {
        if (!$user) {
            $this->user = createUser(true);
        } else {
            $this->user = $user;
        }
        $this->userSettings = Setting::whereUserId($this->user->id);
        $this->actingAs($this->user);

        $custom = Diary::firstOrCreate(['name' => 'custom diary', 'user_id' => $this->user->id]);
        $watched = Diary::getWatched();
        $favourite = Diary::getFavourite();
        $toWatch = Diary::getToWatch();
        $this->diaries = compact('custom', 'watched', 'favourite', 'toWatch');
        return $this;
    }

    public static function getInvalidScreenplayIds()
    {
        return [
            [['screenplayId' => null], ['screenplayId']],
            [['screenplayId' => -1], ['screenplayId']],
            [['screenplayId' => 4.6], ['screenplayId']],
        ];
    }
}
