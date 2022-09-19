<?php

namespace App\Classes\TMDB;

use App\Contracts\TMDB\Searchable;
use Tmdb\Model\AbstractModel;
use Tmdb\Model\Search\SearchQuery;
use Tmdb\Model\Search\SearchQuery\TvSearchQuery;
use Tmdb\Model\Tv;
use Tmdb\Repository\TvRepository;

class SeriesSearcher extends Searcher implements Searchable
{
    public function searchByQuery(
        string $query,
        SearchQuery $parameters = null
    ): array {
        $series = $this->searchRepository
            ->searchTv($query, $parameters ?? $this->getDefaultSearchQuery())
            ->getAll();

        return array_map(
            fn (Tv $series) => $this->searchById($series->getId()),
            $series
        );
    }

    public function searchById(int $id, array $parameters = []): AbstractModel
    {
        return (new TvRepository($this->client))->load($id, $parameters);
    }

    public function getPopular(): array
    {
        return (new TvRepository($this->client))->getPopular()->getAll();
    }

    public function getDefaultSearchQuery(): SearchQuery
    {
        return (new TvSearchQuery())
            ->language(app()->getLocale())
            ->filterAdult(\Auth::user()->settings->adultContent);
    }
}
