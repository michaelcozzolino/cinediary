<?php

declare(strict_types=1);

namespace App\Services\Dashboard\Chart;

use App\Repositories\ScreenplayRepository;
use App\VO\Charts\Chart;
use App\VO\Charts\ChartType;
use App\VO\Charts\Dataset;

class WatchedGenreCountBuilder
{
    public function build(): Chart
    {
        $genres = $counts = [];
        $genreCounts = ScreenplayRepository::getWatchedGenreCounts();

        foreach ($genreCounts as $genreCount) {
            $genres[] = $genreCount->genre;
            $counts[] = $genreCount->genre_count;
        }

        return new Chart(
            $genres,
            [new Dataset(
                'genre count',
                $counts,
                ChartType::Percentage
             )]
        );
    }
}
