<?php

declare(strict_types=1);

namespace App\Models;

use Parental\HasParent;

class WatchedDiary extends Diary
{
    use HasParent;

    /** TODO: name must be capitalized */
    public const DEFAULT_NAME = 'watched';

    public function addScreenplay(int $screenplayId): array
    {
        $this->prepareForScreenplayAddition($screenplayId);

        return $this->addToDiary($this, $screenplayId);
    }

    public function prepareForScreenplayAddition(int $screenplayId): void
    {
        $this->removeFromDiary(ToWatchDiary::first(), $screenplayId);
    }

    public function removeScreenplay(int $screenplayId)
    {
        $this->removeFromDiary(FavouriteDiary::first(), $screenplayId);
        parent::removeScreenplay($screenplayId);
    }
}
