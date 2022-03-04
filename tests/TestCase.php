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

    /**
     * Sign in a specific user or create one.
     *
     * @param User|null $user
     * @return $this
     */
    public function signIn(User $user = null)
    {
        if (!$user) {
            $this->user = createUser(true);
        } else {
            $this->user = $user;
        }

        $this->userSettings = Setting::whereUserId($this->user->id);
        $this->actingAs($this->user);

        if (!is_null($this->user->email_verified_at)) {
            $custom = Diary::firstOrCreate(['name' => 'custom diary', 'user_id' => $this->user->id]);
            $watched = \Auth::user()->watched_diary;
            $favourite = \Auth::user()->favourite_diary;
            $toWatch = \Auth::user()->to_be_watched_diary;
            $this->diaries = compact('custom', 'watched', 'favourite', 'toWatch');
        }

        return $this;
    }

    /**
     * @return array[]
     */
    public static function getInvalidScreenplayIds()
    {
        return [
            [['screenplayId' => null], ['screenplayId']],
            [['screenplayId' => -1], ['screenplayId']],
            [['screenplayId' => 4.6], ['screenplayId']],
        ];
    }
}
