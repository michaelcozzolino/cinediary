<?php

namespace App\Listeners;

use App\Models\FavouriteDiary;
use App\Models\Setting;
use App\Models\ToWatchDiary;
use App\Models\WatchedDiary;
use Illuminate\Auth\Events\Verified;

class InitializeUser
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Verified  $event
     *
     * @return void
     */
    public function handle(Verified $event)
    {
        $user = $event->user;

        Setting::create([
            'user_id' => $user->id,
            'defaultLanguage' => app()->getLocale(),
        ]);

        WatchedDiary::create([
            'user_id' => $user->id,
            'name' => WatchedDiary::DEFAULT_NAME,
        ]);

        FavouriteDiary::create(
            [
                'user_id' => $user->id,
                'name' => FavouriteDiary::DEFAULT_NAME,
            ]
        );

        ToWatchDiary::create(
            [
                'user_id' => $user->id,
                'name' => ToWatchDiary::DEFAULT_NAME,
            ]
        );

    }
}
