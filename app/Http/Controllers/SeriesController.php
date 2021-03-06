<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Traits\Screenplayability;

class SeriesController extends Controller
{
    use Screenplayability;

    protected string $model = Series::class;

    public function __construct()
    {
        $this->init();
    }
}
