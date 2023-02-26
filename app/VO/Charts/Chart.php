<?php

declare(strict_types=1);

namespace App\VO\Charts;

class Chart
{
    public function __construct(
        public readonly array $labels,
        public readonly array $datasets
    ) {

    }
}
