<?php

declare(strict_types=1);

namespace App\Services\Dashboard\Chart;

use App\Repositories\ScreenplayRepository;
use App\VO\Charts\Chart;
use App\VO\Charts\ChartType;
use App\VO\Charts\Dataset;

class ScreenplayCountByLetterBuilder
{
    public function build(): Chart
    {
        $screenplayCountByAlphabetLetters = ScreenplayRepository::getScreenplayCountByAlphabetLetters();
        $alphabet = $this->getAlphabetData();
        $movieData = $seriesData = $alphabet;
        foreach ($screenplayCountByAlphabetLetters as $screenplayCountByAlphabetLetter) {
            $movieLetter = $screenplayCountByAlphabetLetter->movie_letter;
            $seriesLetter = $screenplayCountByAlphabetLetter->series_letter;
            if($movieLetter !== null) {
                $movieData[$movieLetter] = $screenplayCountByAlphabetLetter->screenplay_letter_count;
            } else {
                $seriesData[$seriesLetter] = $screenplayCountByAlphabetLetter->screenplay_letter_count;
            }
        }

        return new Chart(
            array_keys($alphabet),
            [
                new Dataset(
                 'movie count',
                 array_values($movieData),
                 ChartType::Bar
             ),
                new Dataset(
                    'series count',
                    array_values($seriesData),
                    ChartType::Bar
                ),
            ]
        );
    }

    protected function getAlphabetData() {
        $keys = $this->getAlphabet();
        array_unshift($keys, '#');

        return array_fill_keys($keys, 0);
    }

    public function getAlphabet(): array
    {
        return array_map('chr', range(ord('A'), ord('Z')));
    }
}
