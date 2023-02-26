<?php

namespace App\Contracts\TMDB;

use App\Classes\TMDB\ScreenplayParser;
use App\Classes\TMDB\Searcher;
use Illuminate\Support\Collection;

interface FetcherInterface
{
    public function getParser(): ScreenplayParser;

    public function getSearcher(): Searcher;

    public function fetchByQuery(string $query): Collection;

    public function fetchById(int $id, array $parameters = []): array;
}
