<?php

declare(strict_types=1);

namespace App\Classes\TMDB;

use App\Contracts\TMDB\ParserInterface;
use App\Contracts\TMDB\Searchable;
use App\Models\Series;

class SeriesFetcher extends ScreenplayFetcher
{
    protected Series $series;

    public function __construct(
        protected Searchable $searcher,
        protected ParserInterface $parser
    ) {
        parent::__construct($this->searcher, $this->parser);

        $this->series = new Series();
    }

    public function getScreenplay(): Series
    {
        return $this->series;
    }
}
