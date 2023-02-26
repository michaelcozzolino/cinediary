<?php

declare(strict_types=1);

namespace App\Services\Search\Screenplay;

use App\Helpers\ModelHelper;
use App\Registries\FetcherRegistry;
use App\Services\SearchServiceInterface;
use Illuminate\Support\Facades\Session;

class ScreenplaySearchService implements SearchServiceInterface
{
    public const LAST_QUERY_KEY = 'lastQuery';

    public const SCREENPLAYS_KEY = 'searchData';

    public function __construct(protected FetcherRegistry $fetcherRegistry)
    {
    }

    /**
     * Get the query for the last search or an empty string if no search has been performed yet.
     *
     * @return string
     */
    public function getLastSearchQuery(): string
    {
        return Session::get(self::LAST_QUERY_KEY) ?? '';
    }

    /**
     * Get the screenplays resulting from the last search.
     * The result is an empty array if no screenplays have been found or if no search has been performed yet.
     *
     * @return array|
     */
    public function getLastSearchResult(): array
    {
        return Session::get(self::SCREENPLAYS_KEY) ?? [];
    }

    /**
     * @param  string  $query
     *
     * @throws \App\Exceptions\InvalidModelClassNameException
     * @return array
     */
    public function search(string $query): array
    {
        $screenplays = [];
        $screenplayFetchers = $this->fetcherRegistry->getInstances();
        foreach ($screenplayFetchers as $screenplayType => $fetcher) {
            $screenplays[ModelHelper::getTable($screenplayType)] = $fetcher->fetchByQuery($query);
        }

        $this->storeSearchData($query, $screenplays);

        /** TODO: make VO */
        return $screenplays;
    }

    protected function storeSearchData(string $query, array $result): void
    {
        Session::put([self::SCREENPLAYS_KEY => $result, self::LAST_QUERY_KEY => $query]);
    }
}
