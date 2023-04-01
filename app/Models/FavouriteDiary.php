<?php

declare(strict_types=1);

namespace App\Models;

use Parental\HasParent;

class FavouriteDiary extends Diary
{
    use HasParent;

    public const DEFAULT_NAME = 'favourite';

    public function addScreenplay(int $screenplayId): array
    {
        $this->prepareForScreenplayAddition($screenplayId);

        $this->addToDiary(WatchedDiary::first(), $screenplayId);

        return $this->addToDiary($this, $screenplayId);
    }

    public function prepareForScreenplayAddition(int $screenplayId): void
    {
        $this->removeFromDiary(ToWatchDiary::first(), $screenplayId);
    }
}
