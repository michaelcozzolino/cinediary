<?php

declare(strict_types=1);

namespace App\VO;

use JetBrains\PhpStorm\Immutable;

#[immutable]
class Movie
{
    public function __construct(
        public readonly int $id
    ) {

    }
}
