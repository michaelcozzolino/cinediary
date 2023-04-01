<?php

declare(strict_types=1);

namespace App\Services;

interface SearchServiceInterface
{
    public function getLastSearchQuery(): string;

    public function getLastSearchResult(): array;

    /**
     * @param  string  $query
     *
     * @throws \App\Exceptions\InvalidModelClassNameException
     * @return array
     */
    public function search(string $query): array;
}
