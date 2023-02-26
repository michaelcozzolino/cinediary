<?php

namespace App\Classes\TMDB;

use Tmdb\Model\AbstractModel;

class MovieParser extends ScreenplayParser
{
    public function parseReleaseDate(AbstractModel $screenplay): ?\DateTime
    {
        return $screenplay->getReleaseDate() ?: null;
    }

    public function parseTitle(AbstractModel $movie): string
    {
        return $movie->getTitle();
    }

    public function parseRuntime(AbstractModel $screenplay): int
    {
        return $screenplay->getRuntime() ?? -1;
    }
}
