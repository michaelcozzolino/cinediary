<?php

namespace Tests;

use App\Models\Diary;
use App\Models\Movie;
use App\Models\Series;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected User $user;

    protected array $diaries;

    protected array $availableLanguages;

    protected Mockery\MockInterface $movie;

    protected Mockery\MockInterface $series;

    /** TODO: testcase should be improved */
    protected function setUp(): void
    {
        parent::setUp();

        $this->movie = Mockery::mock(Movie::class);
        $this->series = Mockery::mock(Series::class);
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

        $this->userSettings = UserSetting::whereUserId($this->user->id);
        $this->actingAs($this->user);

        if (!is_null($this->user->email_verified_at)) {
            $custom = Diary::firstOrCreate(['name' => 'custom diary', 'user_id' => $this->user->id]);
            $watched = \Auth::user()->watched_diary;
            $favourite = \Auth::user()->favourite_diary;
            $toWatch = \Auth::user()->to_be_watched_diary;
            $this->diaries = compact('custom', 'watched', 'favourite', 'toWatch');
        }
        $this->get(route('home'));

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
