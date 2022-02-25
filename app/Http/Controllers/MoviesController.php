<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Traits\Screenplayability;

class MoviesController extends Controller
{
    use Screenplayability;

    protected string $model = Movie::class;

    public function __construct()
    {
        $this->init();
    }
}
