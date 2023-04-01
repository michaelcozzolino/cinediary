<?php

declare(strict_types=1);

namespace App\Http\Requests\UserSettings\Update;

use Spatie\LaravelData\Data;

class Request extends Data
{
    public function __construct(public bool $adultContent)
    {

    }
}
