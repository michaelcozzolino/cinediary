<?php

declare(strict_types=1);

namespace App\Models;

use Parental\HasParent;

class FavouriteDiary extends Diary
{
    use HasParent;

    public const DEFAULT_NAME = 'favourite';

    public function addScreenplay(Screenplay $screenplay): void
    {
        $this->user->watched_diary->addScreenplay($screenplay);
        parent::addScreenplay($screenplay);
    }

    public function removeScreenplay(Screenplay $screenplay): void
    {
        $this->user->watched_diary->removeScreenplay($screenplay);
        parent::removeScreenplay($screenplay);
    }
}
