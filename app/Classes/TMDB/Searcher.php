<?php

namespace App\Classes\TMDB;

use Tmdb\Repository\SearchRepository;

class Searcher
{
    public function __construct(
        protected Client $client,
        protected SearchRepository $searchRepository
    ) {
    }
}
