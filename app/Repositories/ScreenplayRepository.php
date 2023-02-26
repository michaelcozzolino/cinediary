<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Diary;
use App\Models\WatchedDiary;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class ScreenplayRepository extends BaseRepository
{
    public function findPaginatedByDiary(?MorphToMany $diaryRelation, string $title): LengthAwarePaginator
    {
        return $diaryRelation->where('title', 'like', '%' . $title . '%')->paginate();
    }

    /**
     * Counts the occurrences of a specific screenplay for the specified diaries.
     *
     * @param  int    $screenplayId
     * @param  array  $diaryIds
     *
     * @return int
     */
    public function getScreenplayCountByDiaries(array $diaryIds, string $screenplayType, int $screenplayId): int
    {
        return DB::table('watchables')
                 ->where('watchable_id', $screenplayId)
                 ->where('watchable_type', $screenplayType)
                 ->whereIn('diary_id', $diaryIds)
                 ->count();
    }

    public static function getScreenplayCountByAllTypes(): Collection
    {
        return DB::table('watchables', 'w')->select([
            'w.watchable_type',
            DB::raw('count(w.watchable_type) as screenplay_count'),
        ])->join('diaries as d', 'd.id', '=', 'w.diary_id')
                 ->whereIn('w.diary_id', Diary::all()->pluck('id'))
                 ->groupBy('w.watchable_type')->get();
    }

    public static function getScreenplayCountByAlphabetLetters(): Collection
    {
        $locale = app()->getLocale();
        $select = sprintf(
            '%s,%s,%s',
            'count(*) as screenplay_letter_count',
            "substr(json_extract(m.title, '$.$locale'),2,1) as movie_letter",
            "substr(json_extract(s.title,'$.$locale'),2,1) as series_letter"
        );

        return DB::table('watchables', 'w')
                 ->selectRaw($select)
                 ->join('diaries as d', 'd.id', '=', 'w.diary_id')
                 ->leftJoin('movies as m', function (JoinClause $join) {
                     $join->on('m.id', '=', 'w.watchable_id')
                          ->where('w.watchable_type', '=', 'movie');
                 })
                 ->leftJoin('series as s', function (JoinClause $join) {
                     $join->on('s.id', '=', 'w.watchable_id')
                          ->where('w.watchable_type', '=', 'series');
                 })
                 ->where('d.id', '=', WatchedDiary::setEagerLoads([])->first()->id)
                 ->groupBy(['movie_letter', 'series_letter'])
                 ->get();
    }

    public static function getWatchedGenreCounts(): Collection
    {
        $query = self::getGenreByDiaryQuery('movies', 'movie')
            ->unionAll(self::getGenreByDiaryQuery('series', 'series'));

        return DB::table($query, 'x')
                 ->select(['x.genre', DB::raw('count(x.genre) as genre_count')])
                 ->groupBy('x.genre')
            ->get();
    }

    /** TODO: screenplayTable can be enum, screenplaytype can be refactored in future in config\app.php */
    protected static function getGenreByDiaryQuery(string $screenplayTable, string $screenplayType): Builder
    {
        return DB::table('watchables', 'w')
            ->selectRaw("json_extract($screenplayTable.genre, '$.it') as genre")
          ->join('diaries as d', 'd.id', '=', 'w.diary_id')
            ->join($screenplayTable, "$screenplayTable.id", '=', 'w.watchable_id')
            ->where([
                ['w.watchable_type', '=', $screenplayType],
                ['d.id', '=', WatchedDiary::setEagerLoads([])->first()->id],
            ]);
    }
}
