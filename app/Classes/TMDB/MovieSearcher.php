<?php

declare(strict_types=1);

namespace App\Classes\TMDB;

use App\Contracts\TMDB\Searchable;
use Tmdb\Exception\TmdbApiException;
use Tmdb\Model\AbstractModel;
use Tmdb\Model\Movie;
use Tmdb\Model\Search\SearchQuery;
use Tmdb\Model\Search\SearchQuery\MovieSearchQuery;
use Tmdb\Repository\MovieRepository;

class MovieSearcher extends Searcher implements Searchable
{
    /**
     * @param  string            $query
     * @param  SearchQuery|null  $parameters
     *
     * @throws TmdbApiException
     * @return array
     */
    public function searchByQuery(
        string $query,
        SearchQuery $parameters = null
    ): array {
        /** @var MovieSearchQuery $parameters */
        $parameters = $parameters ?? $this->getDefaultSearchQuery();

        $movies = $this->searchRepository
            ->searchMovie($query, $parameters)
            ->getAll();

        return array_map(
            fn (Movie $movie) => $this->searchById($movie->getId()),
            $movies
        );
    }

    /**
     * @param  int    $id
     * @param  array  $parameters
     *
     * @throws TmdbApiException
     * @return AbstractModel
     */
    public function searchById(int $id, array $parameters = []): AbstractModel
    {
        return (new MovieRepository($this->client))->load($id, $parameters);
    }

    public function getPopular(array $parameters = []): array
    {
        return (new MovieRepository($this->client))
            ->getPopular($parameters)
            ->getAll();
    }

    public function getDefaultSearchQuery(): SearchQuery
    {
        return (new MovieSearchQuery())
            ->language(app()->getLocale())
            ->filterAdult(\Auth::user()->settings->adultContent);
    }
}
