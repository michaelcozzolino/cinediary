<?php

namespace App\Http\Controllers;

use App\Classes\TMDB\ScreenplayFetcher;
use App\Classes\TMDB\Translator;

class SeriesController extends Controller
{
    use ScreenplayController;

    public function __construct(
        protected ScreenplayFetcher $TMDBScreenplayRepository,
        protected Translator        $translator,
    ) {
    }
}
