<?php

declare(strict_types=1);

namespace App\Classes\TMDB;

interface TranslatorInterface
{
    public function translate(string $model, int $id, string $language): array;
}
