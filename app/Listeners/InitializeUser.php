<?php

namespace App\Listeners;

use App\Models\Diary;
use App\Models\Setting;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InitializeUser
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $user = $event->user;

        Setting::create([
            'user_id' => $user->id,
            'defaultLanguage' => app()->getLocale(),
        ]);

        $diariesToCreateNames = [Diary::WATCHED_DIARY_NAME, Diary::FAVOURITE_DIARY_NAME, Diary::TO_WATCH_DIARY_NAME];

        foreach ($diariesToCreateNames as $diaryToCreateName) {
            Diary::create([
                'user_id' => $user->id,
                'isMain' => true,
                'name' => $diaryToCreateName,
            ]);
        }
    }
}