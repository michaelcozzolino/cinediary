<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Diary;
use App\Models\Scopes\UserDiaryScope;
use App\VO\Diaries\Index\Diary as IndexDiary;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class DiaryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Diary::class);
    }

    public function getAllWithScreenplayCountByUser(int $userId): DataCollection
    {
        $query = <<<'SQL'
                    SELECT `diaries`.`id`, `diaries`.`name`, `diaries`.`is_deletable` as isDeletable,
                   (SELECT Count(*)
                    FROM   `movies`
                           INNER JOIN `watchables`
                                   ON `movies`.`id` = `watchables`.`watchable_id`
                    WHERE  `diaries`.`id` = `watchables`.`diary_id`
                           AND `watchables`.`watchable_type` = 'movie' )  AS
                   `moviesCount`,
                   (SELECT Count(*)
                    FROM   `series`
                           INNER JOIN `watchables`
                                   ON `series`.`id` = `watchables`.`watchable_id`
                    WHERE  `diaries`.`id` = `watchables`.`diary_id`
                           AND `watchables`.`watchable_type` = 'series') AS
                   `seriesCount`
                    FROM   `diaries`
                    WHERE  `diaries`.`user_id` = :userId and `diaries`.`deleted_at` is null; 
            SQL;

        $diaries = DB::select($query, [
            'userId' => $userId,
        ]);

        return IndexDiary::collection($diaries);
    }

    /**
     * @param  array  $types
     * @param  array       $attributes
     *
     * @return array<Diary>|Collection
     */
    public function findByTypes(array $types = [], array $attributes = ['*']): array|Collection
    {
        return Diary::withoutGlobalScope(new UserDiaryScope())
                    ->whereIn('type', $types, not: $types === [])
                    ->get($attributes);
    }

    public function getIdsByTypes(array $types = []): array
    {
        return $this->findByTypes($types, ['id'])->pluck('id')->toArray();
    }
}
