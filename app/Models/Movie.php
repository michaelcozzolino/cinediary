<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\ScreenplayActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Movie.
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Diary[] $diaries
 * @property-read int|null $diaries_count
 * @property array|null $genre
 * @property int $isPopular
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereIsPopular($value)
 */
class Movie extends Model
{
    use HasFactory;
    use HasTranslations;
    use ScreenplayActions;

    public $incrementing = false;
    protected $guarded = [];
    protected $perPage = 20;
    protected $casts = [
        'releaseDate' => 'datetime:Y',
    ];

    public array $translatable = ['title', 'posterPath', 'backdropPath', 'overview', 'genre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function diaries()
    {
        return $this->belongsToMany(Diary::class)->withTimestamps();
    }
}
