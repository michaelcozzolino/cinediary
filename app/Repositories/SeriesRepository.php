<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Series;

class SeriesRepository extends ScreenplayRepository
{
    public function __construct()
    {
        parent::__construct(Series::class);
    }
}
