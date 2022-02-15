<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\ScreenplayActions;
use App\Traits\ScreenplaysScopesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @method static \Illuminate\Database\Eloquent\Builder|Series movies()
 */
class Series extends Model
{
    use HasFactory, HasTranslations, ScreenplayActions;
    public array $translatable = ['title', 'originalTitle', 'posterPath', 'backdropPath','overview', 'genre'];
    public $incrementing = false;
    protected $guarded = [];
    protected $casts = [
        'releaseDate' => 'datetime:Y',
    ];

    public function diaries(){
        return $this->belongsToMany(Diary::class)
            ->withTimestamps();
    }
}
