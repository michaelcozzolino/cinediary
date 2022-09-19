<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Movie;

class MovieRepository extends BaseRepository
{
    protected function model(): string
    {
        return Movie::class;
    }
}
