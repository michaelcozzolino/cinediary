<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\Diary\MissingScreenplayFromDiaryException;
use App\Traits\ExceptionContext;
use Log;
use Parental\HasParent;

class ToWatchDiary extends Diary
{
    use hasParent;

    public const DEFAULT_NAME = 'to watch';

    public const DEFAULT_NAME2 = 'to watch';

    public function addScreenplay(Screenplay $screenplay): void
    {
        try {
            $this->user->favourite_diary->removeScreenplay($screenplay);
        } catch (MissingScreenplayFromDiaryException $e) {
            Log::info(
                'Impossible to remove screenplay from favourite diary because it is missing.',
                ['exception' => ExceptionContext::getContext($e)]
            );
        }

        parent::addScreenplay($screenplay);
    }
}
