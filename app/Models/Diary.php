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
 * @method static Builder|Diary watchList()
// * @method static Builder|Diary watched()
 * @method static Builder|Diary whereIsMain($value)
 * @method static Builder|Diary watchedMovies()
 */
class Diary extends Model
{
    use HasFactory;
    protected $guarded = [];
    public const WATCHED_DIARY_NAME = "watched";
    public const FAVOURITE_DIARY_NAME = "favourite";
    public const TO_WATCH_DIARY_NAME = "to watch";
    protected $with = ['movies', 'series'];
    protected static function booted() {
        parent::booted();

        static::addGlobalScope('userDiaries', function (Builder $builder){
           $builder->where('user_id', \Auth::id());
        });

    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function movies(){
        return $this->belongsToMany(Movie::class)
            ->withTimestamps();
    }

    public function series(){
        return $this->belongsToMany(Series::class)->withTimestamps();
    }

    public static function getWatched() : Diary {
        return self::watched()->first();
    }

    public function scopeWatched(Builder $builder){
        return $builder->where('name', self::WATCHED_DIARY_NAME)->main();
    }

    public static function toWatch() : Diary {
        return self::where('name', self::TO_WATCH_DIARY_NAME)->main()->first();
    }


    public static function favourite() : Diary {
        return self::where('name', self::FAVOURITE_DIARY_NAME)->main()->first();
    }

    public function scopeMain(Builder $builder) : Builder {
        return $builder->where('isMain', true);
    }

    public function isWatched(){
        return $this->name === self::WATCHED_DIARY_NAME && $this->isMain;
    }

    public function isFavourite(){
        return $this->name === self::FAVOURITE_DIARY_NAME && $this->isMain;
    }

    public function isToWatch(){
        return $this->name === self::TO_WATCH_DIARY_NAME && $this->isMain;
    }

    public function delete() {
        if (! $this->isMain)
            return parent::delete();
        else
            return false;
    }

    public function getLastAddedScreenplays(string $screenplayType, int $count){
        return $this->{$screenplayType}()->orderBy('created_at', 'desc')->limit($count)->get();
    }


}
