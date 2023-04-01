<?php

namespace App\Contracts\TMDB;

use Tmdb\Model\AbstractModel;
use Tmdb\Model\Search\SearchQuery;

interface Searchable
{
    public function searchByQuery(string $query, SearchQuery $parameters = null): array;

    public function searchById(int $id, array $parameters = []): AbstractModel;

    public function getPopular(): array;

    public function getDefaultSearchQuery(): SearchQuery;
}
