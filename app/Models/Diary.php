<?php

namespace App\Models;

use App\Contracts\DiaryInterface;
use App\Exceptions\Diary\MissingScreenplayFromDiaryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Log;
use Parental\HasChildren;

/**
 * App\Models\Diary.
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
 * @method static \Illuminate\Database\Eloquent\Builder|Diary toBeWatched()
 * @method static \Illuminate\Database\Eloquent\Builder|Diary watched()
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|Diary whereType($value)
 */
class Diary extends Model implements DiaryInterface
{
    use HasFactory;
    use HasChildren;

    protected $guarded = [];

    public const DEFAULT_NAME = '';

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
     * Get the to be watched diary builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToBeWatched(Builder $builder)
    {
        return $builder->whereName(self::TO_BE_WATCHED_DIARY_NAME);
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
        }

        return false;
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

    /** TODO: delete exists in diary in screenplay.
     *
     * @throws MissingScreenplayFromDiaryException
     */
    protected function hasScreenplay(Screenplay $screenplay): void
    {
        $hasScreenplay = self::whereHas(
            $screenplay->getTable(),
            function ($builder) use ($screenplay) {
                $builder->where(getClassName($screenplay::class) . '_id', '=', $this->id);
            }
        )->exists();

        if ($hasScreenplay === false) {
            throw new MissingScreenplayFromDiaryException(
                sprintf('Screenplay %s #%d does not exist in this diary', $screenplay::class, $screenplay->id)
            );
        }
    }

    public function addScreenplay(Screenplay $screenplay): void
    {
        try {
            $this->hasScreenplay($screenplay);
        } catch (MissingScreenplayFromDiaryException $e) {
            $relation = $this->{$screenplay->getTable()}();
            $relation->syncWithoutDetaching([$screenplay->id]);
            Log::info(
                sprintf(
                    'Added screenplay %s #%u to diary %s #%u',
                    $screenplay::class,
                    $screenplay->id,
                    static::class,
                    $this->id
                )
            );
        }
    }

    /** TODO: message check.
     *
     * @throws MissingScreenplayFromDiaryException
     */
    public function removeScreenplay(Screenplay $screenplay): void
    {
        /** @var BelongsToMany $relation */
        $relation = $this->{$screenplay->getTable()}();

        $removed = $relation->detach($screenplay->id);

        if($removed === 0) {
            throw new MissingScreenplayFromDiaryException(
                sprintf('Screenplay %s #%d does not exist in this diary', $screenplay::class, $screenplay->id)
            );
        }

        Log::info(
            sprintf(
                'Removed screenplay %s #%u from diary %s #%u',
                $screenplay::class,
                $screenplay->id,
                static::class,
                $this->id
            )
        );

        session()->flash(
            'message',
            __('flash.screenplay_removed', ['screenplay_title' => $screenplay->title])
        );
    }
}
