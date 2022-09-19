<?php

declare(strict_types=1);

namespace App\Classes\TMDB;

use App\Contracts\TMDB\ParserInterface;
use App\Contracts\TMDB\Searchable;
use App\Models\Movie;

class MovieFetcher extends ScreenplayFetcher
{
    protected Movie $movie;

    public function __construct(
        protected Searchable $searcher,
        protected ParserInterface $parser
    ) {
        parent::__construct($this->searcher, $this->parser);

        $this->movie = new Movie();
    }

    public function getScreenplay(): Movie
    {
        return $this->movie;
    }
}
