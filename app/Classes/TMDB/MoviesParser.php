<?php

namespace App\Classes\TMDB;

use Tmdb\Model\AbstractModel;

class MoviesParser extends Parser
{
    public function parseReleaseDate(AbstractModel $screenplay): ?\DateTime
    {
        return $screenplay->getReleaseDate() ?: null;
    }

    public function parseTitle(AbstractModel $screenplay): string
    {
        return $screenplay->getTitle();
    }

    public function parseRuntime(AbstractModel $screenplay): int
    {
        return $screenplay->getRuntime() ?? -1;
    }
}
