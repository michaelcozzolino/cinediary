<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Movie
 *
 * @property int $id
 * @property string $title
 * @property string $originalTitle
 * @property string $posterPath
 * @property string $backdropPath
 * @property string $overview
 * @property string $releaseDate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Movie favourite()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie watched()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereBackdropPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereOriginalTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereOverview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie wherePosterPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $runtime
 * @property int $upcoming
 * @method static \Database\Factories\MovieFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie watchList()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereRuntime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereUpcoming($value)
 */
	class Movie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Series
 *
 * @property int $id
 * @property string $title
 * @property string $originalTitle
 * @property string $posterPath
 * @property string $backdropPath
 * @property string $overview
 * @property string $releaseDate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Series newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Series newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Series query()
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereBackdropPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereOriginalTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereOverview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series wherePosterPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Series favourite()
 * @method static \Illuminate\Database\Eloquent\Builder|Series watched()
 * @method static \Illuminate\Database\Eloquent\Builder|Series watchList()
 */
	class Series extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Movie[] $movies
 * @property-read int|null $movies_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

