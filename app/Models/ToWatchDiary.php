<?php

declare(strict_types=1);

namespace App\Models;

use Parental\HasParent;

class ToWatchDiary extends Diary
{
    use hasParent;

    public const DEFAULT_NAME = 'to watch';

    public function addScreenplay(int $screenplayId): array
    {
        $this->prepareForScreenplayAddition($screenplayId);

        return $this->addToDiary($this, $screenplayId);
    }

    public function prepareForScreenplayAddition(int $screenplayId): void
    {
        $this->removeFromDiary(FavouriteDiary::first(), $screenplayId);
        $this->removeFromDiary(WatchedDiary::first(), $screenplayId);
    }
}
