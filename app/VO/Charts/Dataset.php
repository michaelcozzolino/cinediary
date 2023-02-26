<?php

declare(strict_types=1);

namespace App\VO\Charts;

class Dataset
{
    public function __construct(
        public readonly string $name,
        public readonly array $values,
        public readonly ChartType $chartType,
    ) {
    }
}
