<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Movie;

class MovieRepository extends ScreenplayRepository
{
    public function __construct()
    {
        parent::__construct(Movie::class);
    }
}
