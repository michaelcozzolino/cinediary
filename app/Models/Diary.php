<?php

namespace App\Models;

use App\Contracts\Models\DiaryInterface;
use App\Models\Scopes\UserDiaryScope;
use App\Services\ScreenplayContextService;
use App\Traits\Watchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;

/**
 * App\Models\Diary.
 *
 * @property int                                                                $id
 * @property string                                                             $name
 * @property int                                                                $user_id
 * @property \Illuminate\Support\Carbon|null                                    $created_at
 * @property \Illuminate\Support\Carbon|null                                    $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Movie[]  $movies
 * @property-read int|null                                                      $movies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[]   $users
 * @property-read int|null                                                      $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Diary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary query()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Series[] $series
 * @property-read int|null                                                      $series_count
 * @property-read \App\Models\User                                              $user
 * @method static \Database\Factories\DiaryFactory factory(...$parameters)
 * @method static Builder|Diary whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diary favourite()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary main()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary toBeWatched()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary watched()
 * @property string                                                             $type
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereType($value)
 */
class Diary extends Model implements DiaryInterface
{
    use HasFactory;
    use HasChildren;
    use SoftDeletes;
    use Watchable;

    public function __construct(array $attributes = [])
    {
        $this->screenplayContextService = app(ScreenplayContextService::class);
        parent::__construct($attributes);
    }

    protected $guarded = [];

    public const DEFAULT_NAME = '';

    protected $with = ['movies', 'series'];

    protected $casts = ['is_deletable' => 'boolean'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new UserDiaryScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movies(): MorphToMany
    {
        return $this->morphedByMany(Movie::class, 'watchable');
    }

    public function series(): MorphToMany
    {
        return $this->morphedByMany(Series::class, 'watchable');
    }

    /**
     * Get the latest {$count} screenplays added to the diary.
     *
     * @param  string  $screenplayType
     * @param  int     $count
     *
     * @return mixed
     */
    public function getLatestAddedScreenplays(string $screenplayType, int $count)
    {
        return $this->{$screenplayType}()
                    ->orderBy('created_at', 'desc')
                    ->limit($count)
                    ->get();
    }

    public function addScreenplay(int $screenplayId): array
    {
        return $this->addToDiary($this, $screenplayId);
    }

    public function prepareForScreenplayAddition(int $screenplayId): void
    {

    }

    public function removeScreenplay(int $screenplayId)
    {
        $this->removeFromDiary($this, $screenplayId);
    }
}
