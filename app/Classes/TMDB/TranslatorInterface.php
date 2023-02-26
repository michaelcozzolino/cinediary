<?php

declare(strict_types=1);

namespace App\Classes\TMDB;

use App\Models\Screenplay;

interface TranslatorInterface
{
//    /**
//     * Get the screenplay matching the given id and translate it if possible.
//     *
//     * @param  int     $id
//     * @param  array   $languages
//     *
//     * @throws ResourceNotTranslatableException
//     * @return Screenplay
//     */
//    public function firstOrTranslate(
//        int   $id,
//        array $languages = [],
//    ): Screenplay;

//    public function isFieldTranslatable(string $field): bool;

    public function translate(string $model, int $id, string $language): array;
}
