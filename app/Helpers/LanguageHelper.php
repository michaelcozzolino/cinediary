<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class LanguageHelper
{
    /**
     * @return array<string>
     */
    public static function getAvailableLanguages(): array
    {
        return Config::get('app.available_locales');
    }
}
