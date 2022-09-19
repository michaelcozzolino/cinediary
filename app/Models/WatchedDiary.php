<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\Diary\MissingScreenplayFromDiaryException;
use App\Traits\ExceptionContext;
use Log;
use Parental\HasParent;

class WatchedDiary extends Diary
{
    use HasParent;

    public const DEFAULT_NAME = 'watched';

    public function addScreenplay(Screenplay $screenplay): void
    {
        try {
            $this->user?->to_watch_diary->removeScreenplay($screenplay);
        } catch (MissingScreenplayFromDiaryException $e) {
            Log::info(
                'Impossible to remove screenplay from to watch diary because it is missing.',
                ['exception' => ExceptionContext::getContext($e)]

            );
        }

        parent::addScreenplay($screenplay);
    }
}
