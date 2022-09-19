<?php

namespace App\Contracts\TMDB;

use Illuminate\Support\Collection;

interface FetcherInterface
{
    public function getParser(): ParserInterface;

    public function getSearcher(): Searchable;

    public function findByQuery(string $query): Collection;

    public function findById(int $id, array $parameters = []): array;
}
