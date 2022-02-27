<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Diary
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Movie[] $movies
 * @property-read int|null $movies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Diary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary query()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereUserId($value)
 * @mixin \Eloquent
 * @property int $isMain
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Series[] $series
 * @property-read int|null $series_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\DiaryFactory factory(...$parameters)
 * @method static Builder|Diary whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diary favourite()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary main()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary toWatch()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary watched()
 */
class Diary extends Model
{
    use HasFactory;
    protected $guarded = [];
    public const WATCHED_DIARY_NAME = 'Watched';
    public const FAVOURITE_DIARY_NAME = 'Favourite';
    public const TO_WATCH_DIARY_NAME = 'to watch';
    protected $with = ['movies', 'series'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope('userDiaries', function (Builder $builder) {
            $builder->where('user_id', \Auth::id());
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function series()
    {
        return $this->belongsToMany(Series::class)->withTimestamps();
    }

    /**
     * Get watched diary object.
     *
     * @return Diary
     */
    public static function getWatched(): Diary
    {
        return self::watched()->first();
    }

    /**
     * Get watched diary builder.
     *
     * @param Builder $builder
     * @return mixed
     */
    public function scopeWatched(Builder $builder)
    {
        return $builder->where('name', self::WATCHED_DIARY_NAME)->main();
    }

    /**
     * Get to watch diary object.
     *
     * @return Diary
     */
    public static function getToWatch(): Diary
    {
        return self::toWatch()->first();
    }

    /**
     * Get to watch diary builder.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeToWatch(Builder $builder): Builder
    {
        return $builder->where('name', self::TO_WATCH_DIARY_NAME)->main();
    }

    /**
     * Get favourite diary object.
     *
     * @return Diary
     */
    public static function getFavourite(): Diary
    {
        return self::favourite()->first();
    }

    /**
     *  Get favourite diary builder.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeFavourite(Builder $builder): Builder
    {
        return $builder->where('name', self::FAVOURITE_DIARY_NAME)->main();
    }

    /**
     * Get main diaries builder.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeMain(Builder $builder): Builder
    {
        return $builder->where('isMain', true);
    }

    /**
     * Check if the diary is the watched one.
     *
     * @return bool
     */
    public function isWatched()
    {
        return $this->name === self::WATCHED_DIARY_NAME && $this->isMain;
    }

    /**
     * Check if the diary is the favourite one.
     *
     * @return bool
     */
    public function isFavourite()
    {
        return $this->name === self::FAVOURITE_DIARY_NAME && $this->isMain;
    }

    /**
     * Check if the diary is the to watch one.
     *
     * @return bool
     */
    public function isToWatch()
    {
        return $this->name === self::TO_WATCH_DIARY_NAME && $this->isMain;
    }

    /**
     * Delete the diary from the database. Only custom diaries can be deleted.
     *
     * @return bool|null
     *
     * @throws \LogicException
     */
    public function delete()
    {
        if (!$this->isMain) {
            return parent::delete();
        } else {
            return false;
        }
    }

    /**
     * Get the latest {$count} screenplays added to the diary.
     *
     * @param string $screenplayType
     * @param int $count
     * @return mixed
     */
    public function getLatestAddedScreenplays(string $screenplayType, int $count)
    {
        return $this->{$screenplayType}()
            ->orderBy('created_at', 'desc')
            ->limit($count)
            ->get();
    }
}
