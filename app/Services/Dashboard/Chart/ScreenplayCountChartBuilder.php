<?php

declare(strict_types=1);

namespace App\Services\Dashboard\Chart;

use App\Repositories\ScreenplayRepository;
use App\VO\Charts\Chart;
use App\VO\Charts\ChartType;
use App\VO\Charts\Dataset;
use Str;

class ScreenplayCountChartBuilder
{
    public function build(): Chart
    {
        $screenplayCountByAllTypes = ScreenplayRepository::getScreenplayCountByAllTypes()->toArray();

        $screenplayTypes = [];
        $screenplayCounts = [];
        foreach ($screenplayCountByAllTypes as $screenplayCountByType) {
            $screenplayTypes[] = Str::plural($screenplayCountByType->watchable_type);
            $screenplayCounts[] = $screenplayCountByType->screenplay_count;
        }

        return new Chart(
            $screenplayTypes,
            [new Dataset(
                'screenplay count',
                $screenplayCounts,
                ChartType::Percentage
            )]
        );
    }
}
