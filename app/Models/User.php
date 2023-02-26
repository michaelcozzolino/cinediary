<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User.
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
 * @property-read WatchedDiary $watched_diary
 * @property-read FavouriteDiary $favourite_diary
 * @property-read ToWatchDiary $to_watch_diary
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Diary[] $diaries
 * @property-read int|null                                                     $diaries_count
 * @property-read \App\Models\UserSetting|null                                 $settings
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['watched_diary', 'favourite_diary', 'to_watch_diary'];

    protected WatchedDiary $watchedDiary;

    protected FavouriteDiary $favouriteDiary;

    protected ToWatchDiary $toWatchDiary;

    /**
     * @return HasMany
     */
    public function diaries()
    {
        return $this->hasMany(Diary::class);
    }

    /**
     * @return HasOne
     */
    public function settings()
    {
        return $this->hasOne(UserSetting::class);
    }

    /**
     * Get the watched diary attribute.
     *
     * @return Attribute
     */
    protected function watchedDiary(): Attribute
    {
        return new Attribute(
            get: fn () => WatchedDiary::setEagerLoads([])->first(),
        );
    }

    /**
     * Get the favourite diary attribute.
     *
     * @return Attribute
     */
    protected function favouriteDiary(): Attribute
    {
        return new Attribute(
            get: fn () => FavouriteDiary::setEagerLoads([])->first(),
        );
    }

    /**
     * Get the to be watched diary attribute.
     *
     * @return Attribute
     */
    protected function toWatchDiary(): Attribute
    {
        return new Attribute(
            get: fn () => ToWatchDiary::setEagerLoads([])->first(),
        );
    }
}
