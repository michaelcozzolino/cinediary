<?php

namespace App\Contracts\TMDB;

use Tmdb\Model\AbstractModel;

interface ScreenplayParserInterface extends ParserInterface
{
    public function parseTitle(AbstractModel $screenplay): string;

    public function parseReleaseDate(AbstractModel $screenplay): ?\DateTime;
}
