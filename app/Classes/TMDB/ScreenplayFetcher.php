<?php

namespace App\Classes\TMDB;

use App\Contracts\TMDB\FetcherInterface;
use App\Contracts\TMDB\ParserInterface;
use App\Contracts\TMDB\Searchable;
use App\Models\Screenplay;
use Illuminate\Support\Collection;
use Tmdb\Exception\TmdbApiException;

abstract class ScreenplayFetcher implements FetcherInterface
{
    public function __construct(
        protected Searchable $searcher,
        protected ParserInterface $parser
    ) {
    }

    public function getParser(): ParserInterface
    {
        return $this->parser;
    }

    public function getSearcher(): Searchable
    {
        return $this->searcher;
    }

    public function findByQuery(string $query): Collection
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
    public function findById(int $id, array $parameters = []): array
    {
        return $this->parser->parseOne(
            $this->searcher->searchById($id, $parameters)
        );
    }

    public function findPopular()
    {
        return $this->parser->parseMany($this->searcher->getPopular());
    }

    abstract public function getScreenplay(): Screenplay;
}
