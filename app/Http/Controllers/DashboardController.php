<?php

namespace App\Http\Controllers;

use App\Services\Dashboard\Chart\ScreenplayCountByLetterBuilder;
use App\Services\Dashboard\Chart\ScreenplayCountChartBuilder;
use App\Services\Dashboard\Chart\WatchedGenreCountBuilder;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class DashboardController extends Controller
{
    public function index(
        ScreenplayCountChartBuilder $screenplayCountChartBuilder,
        ScreenplayCountByLetterBuilder $screenplayCountByLetterBuilder,
        WatchedGenreCountBuilder $watchedGenreCountBuilder
    ): InertiaResponse {
        $charts = [];
        $charts['screenplayCount'] = $screenplayCountChartBuilder->build();
        $charts['screenplayCountByAlphabetLetters'] = $screenplayCountByLetterBuilder->build();
        $charts['watchedGenreCount'] = $watchedGenreCountBuilder->build();

        return Inertia::render(
            'Home/Dashboard/Index',
            compact('charts', )
        );
    }
}
