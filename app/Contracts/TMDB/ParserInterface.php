<?php

declare(strict_types=1);

namespace App\Contracts\TMDB;

use Illuminate\Support\Collection;

interface ParserInterface
{
    public function parseOne($screenplay): array;

    public function parseMany(array $screenplays): Collection;
}
