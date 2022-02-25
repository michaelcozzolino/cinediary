<?php

use App\Models\Diary;
use App\Models\Setting;
use App\Models\User;

/**
 * Create a random user.
 *
 * @param bool $emailVerified
 * @return App\Models\User
 */
function createUser(bool $emailVerified = false)
{
    $user = User::factory()->create([
        'email_verified_at' => $emailVerified ? now() : null,
    ]);

    createNewUserDiaries($user);
    createUserSettings($user);
    return $user;
}

/**
 * Create the main user diaries for an user.
 *
 * @param $user
 */
function createNewUserDiaries($user)
{
    $diariesNames = [Diary::WATCHED_DIARY_NAME, Diary::FAVOURITE_DIARY_NAME, Diary::TO_WATCH_DIARY_NAME];

    foreach ($diariesNames as $diaryName) {
        createDiary(['name' => $diaryName, 'user_id' => $user->id, 'isMain' => 1]);
    }
}

/**
 * Create the settings for a user.
 *
 * @param $user
 * @param array $attributes
 * @return Setting|\Illuminate\Database\Eloquent\Model
 */
function createUserSettings($user, $attributes = [])
{
    return Setting::create(array_merge(['user_id' => $user->id], $attributes));
}

/**
 * Create a random diary.
 *
 * @param array $attributes
 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
 */
function createDiary($attributes = [])
{
    return Diary::factory()->create($attributes);
}

/**
 * Create random movies.
 *
 * @param $count
 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
 */
function createMovies($count)
{
    return \App\Models\Movie::factory()
        ->count($count)
        ->create();
}

/**
 * Create random series.
 *
 * @param $count
 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
 */
function createSeries($count)
{
    return \App\Models\Series::factory()
        ->count($count)
        ->create();
}
