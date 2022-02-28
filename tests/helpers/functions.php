<?php

use App\Models\Diary;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

/**
 * Create a random user.
 *
 * @param bool $emailVerified
 * @return App\Models\User
 */
function createUser(bool $emailVerified = false)
{
    if ($emailVerified) {
        $user = User::factory()->create();
        event(new Verified($user));
    } else {
        $user = User::factory()
            ->unverified()
            ->create();
    }

    return $user;
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
