<?php

declare(strict_types=1);

namespace App\Contracts\Models;

interface DiaryInterface
{
    public function addScreenplay(int $screenplayId): array;

    public function prepareForScreenplayAddition(int $screenplayId): void;
}
