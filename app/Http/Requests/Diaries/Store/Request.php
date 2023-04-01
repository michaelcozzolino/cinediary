<?php

declare(strict_types=1);

namespace App\Http\Requests\Diaries\Store;

class Request extends \Spatie\LaravelData\Data
{
    public function __construct(
        public string $diaryName
    ) {
    }
}
