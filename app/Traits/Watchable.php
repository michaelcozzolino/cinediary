<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\ScreenplayAlreadyInDiaryException;
use App\Models\Diary;
use App\Services\ScreenplayContextService;
use App\VO\Screenplays\ScreenplayContext;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Watchable
{
    public function addToDiary(Diary $diary, int $screenplayId): array
    {
        /** @var ScreenplayContext $screenplayContext */
        $screenplayContext = app(ScreenplayContextService::class)->getScreenplayContext();

        try {
            $this->guardAgainstScreenplayAlreadyInDiary($screenplayContext->type, $diary->id, $screenplayId);
        } catch (ScreenplayAlreadyInDiaryException) {
            return [];
        }

        return $this->syncToScreenplay(
            $screenplayContext->getDiaryRelation($diary),
            $screenplayId
        );
    }

    public function removeFromDiary(Diary $diary, int $screenplayId)
    {
        /** @var ScreenplayContext $screenplayContext */
        $screenplayContext = app(ScreenplayContextService::class)->getScreenplayContext();

        $removed = $screenplayContext->getDiaryRelation($diary)->detach([$screenplayId]);
    }

    /**
     * Synchronize the pivot table between the diary and the screenplay.
     *
     * @param  MorphToMany  $diaryRelation
     * @param  int          $screenplayId
     *
     * @return array
     */
    protected function syncToScreenplay(MorphToMany $diaryRelation, int $screenplayId): array
    {
        return $diaryRelation->syncWithoutDetaching([$screenplayId])['attached'];
    }

    /**
     * @param  string  $screenplayType
     * @param  int     $diaryId
     * @param  int     $screenplayId
     *
     * @throws ScreenplayAlreadyInDiaryException
     * @return void
     */
    protected function guardAgainstScreenplayAlreadyInDiary(
        string $screenplayType,
        int $diaryId,
        int $screenplayId
    ): void {
        if ($this->hasScreenplay($screenplayType, $screenplayId, $diaryId)) {
            throw new ScreenplayAlreadyInDiaryException(
                sprintf(
                    '%s is already in diary #%u', $screenplayType, $diaryId
                )
            );
        }
    }

    /**
     * Checks if the given screenplay is in the given diary.
     */
    protected function hasScreenplay(string $screenplayType, int $screenplayId, int $diaryId): bool
    {
        /** @var ScreenplayContext $screenplayContext */
        $screenplayContext = app(ScreenplayContextService::class)->getScreenplayContext();

        return $screenplayContext->repository
                ->getScreenplayCountByDiaries(
                    [$diaryId],
                    $screenplayType,
                    $screenplayId
                ) === 1;
    }
}
