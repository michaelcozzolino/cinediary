<?php

declare(strict_types=1);

namespace App\Services;

use App\Classes\TMDB\Translator;
use App\Exceptions\ScreenplayNotTranslatableException;
use App\Helpers\LanguageHelper;
use App\Models\Screenplay;

class ScreenplayService
{
    public function __construct(
        protected Translator $translatorService,
    ) {

    }

    /**
     * @param  class-string  $model
     * @param  int     $id
     *
     * @throws ScreenplayNotTranslatableException
     * @return Screenplay
     */
    public function store(string $model, int $id): Screenplay
    {
        $screenplay = $this->translatorService->firstOrTranslate(
            $model,
            $id,
            LanguageHelper::getAvailableLanguages()
        );

        $screenplay->save();

        return $screenplay;
    }
}
