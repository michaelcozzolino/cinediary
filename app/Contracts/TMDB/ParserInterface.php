<?php

namespace App\Contracts\TMDB;

use Illuminate\Support\Collection;
use Tmdb\Model\AbstractModel;

interface ParserInterface
{
    public function parseTitle(AbstractModel $screenplay): string;

    public function parseReleaseDate(AbstractModel $screenplay): ?\DateTime;

    public function parseOne($screenplay): array;

    public function parseMany(array $screenplays): Collection;
}
