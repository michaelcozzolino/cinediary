<?php

use App\Models\Movie;
use App\Models\Series;

return [
    /*
    |--------------------------------------------------------------------------
    | Max homepage's screenplays
    |--------------------------------------------------------------------------
    |
    | The number of maximum screenplays that will be showed for each section
    | in the homepage, such as upcoming movies.
    |
    */

    'homepage_max_screenplays' => 6,

    /*
    |--------------------------------------------------------------------------
    | Homepage's screenplays per row
    |--------------------------------------------------------------------------
    |
    | The number of screenplays that will be showed for each section
    | in the homepage on each row.
    |
    */

    'homepage_screenplays_per_row' => 2,

    /*
    |--------------------------------------------------------------------------
    | Screenplay models
    |--------------------------------------------------------------------------
    |
    | The possible available screenplay models
    |
    */

    'screenplay_models' => [new Movie(), new Series()],

    /*
    |--------------------------------------------------------------------------
    | Pagination limit
    |--------------------------------------------------------------------------
    |
    | The number of maximum screenplays to show in a single page
    |
    */

    'pagination_limit' => 20,
];
