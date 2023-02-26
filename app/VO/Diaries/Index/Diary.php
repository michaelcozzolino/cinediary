<?php

declare(strict_types=1);

namespace App\VO\Diaries\Index;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class Diary extends Data
{
    public function __construct(
        public readonly Lazy|int    $id,
        public readonly Lazy|string $name,
        public readonly Lazy|bool   $isDeletable,
        public readonly Lazy|int    $moviesCount,
        public readonly Lazy|int    $seriesCount,
    ) {

    }
}
