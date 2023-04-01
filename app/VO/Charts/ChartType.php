<?php

declare(strict_types=1);

namespace App\VO\Charts;

enum ChartType: string
{
    case Bar = 'bar';
    case Percentage = 'percentage';
    case Donut = 'donut';
}
