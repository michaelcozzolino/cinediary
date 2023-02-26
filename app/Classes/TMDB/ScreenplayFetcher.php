<?php

namespace App\Classes\TMDB;

use App\Contracts\TMDB\FetcherInterface;
use Illuminate\Support\Collection;
use Tmdb\Exception\TmdbApiException;

class ScreenplayFetcher implements FetcherInterface
{
    public function __construct(
        protected Searcher $searcher,
        protected ScreenplayParser $parser
    ) {
    }

    public function getParser(): ScreenplayParser
    {
        return $this->parser;
    }

    public function getSearcher(): Searcher
    {
        return $this->searcher;
    }

    public function fetchByQuery(string $query): Collection
    {
        return $this->parser->parseMany($this->searcher->searchByQuery($query));
    }

    /**
     * @param  int    $id
     * @param  array  $parameters
     *
     * @throws TmdbApiException
     * @return array
     */
    public function fetchById(int $id, array $parameters = []): array
    {
        return $this->parser->parseOne(
            $this->searcher->searchById($id, $parameters)
        );
    }

    public function fetchPopular()
    {
        return $this->parser->parseMany($this->searcher->getPopular());
    }
}
