<?php

use App\Models\Diary;
use App\Models\Setting;

function createNewUserDiaries($user){
    $diariesNames = [Diary::WATCHED_DIARY_NAME, Diary::FAVOURITE_DIARY_NAME, Diary::TO_WATCH_DIARY_NAME];

    foreach ($diariesNames as $diaryName){
        createDiary(['name' => $diaryName, 'user_id' => $user->id, 'isMain' => 1]);
    }
}

function createUserSettings($user, $attributes = []){
    return Setting::create(array_merge(['user_id' => $user->id], $attributes));
}

function createDiary($attributes = []){
    return Diary::factory()->create($attributes);
}

function createMovies($count){
    return \App\Models\Movie::factory()->count($count)->create();
}

function createSeries($count){
    return \App\Models\Series::factory()->count($count)->create();
}


