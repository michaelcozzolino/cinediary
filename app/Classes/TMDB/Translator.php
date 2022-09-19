<?php

namespace App\Classes\TMDB;

use App\Models\Screenplay;
use Tmdb\Exception\TmdbApiException;

class Translator
{
    public function __construct(protected ScreenplayFetcher $screenplayFetcher)
    {
    }

    /**
     * Get the screenplay matching the given id and translate it if possible.
     *
     * @param  int    $id
     * @param  array  $languages
     *
     * @return null|Screenplay
     */
    public function firstOrTranslate(
        int $id,
        array $languages = []
    ): ?Screenplay {
        /** TODO: Maybe rename screenplay to facade */
        $screenplayInstance = $this->screenplayFetcher->getScreenplay();

        $screenplay = $screenplayInstance::find($id);

        if ($screenplay === null) {
            $screenplayTranslations = $this->getTranslations($id, $languages);

            if ($screenplayTranslations !== []) {
                $screenplay = new $screenplayInstance($screenplayTranslations);
            }
        }

        return $screenplay;
    }

    private function isFieldTranslatable(string $field): bool
    {
        return in_array(
            $field,
            $this->screenplayFetcher
                ->getScreenplay()
                ->getTranslatableAttributes()
        );
    }

    public function getTranslations(int $id, array $languages = []): array
    {
        if ($languages === []) {
            $languages = config('app.available_locales');
        }

        $translations = [];

        foreach ($languages as $language) {
            try {
                $translationData = $this->translate($id, $language);
                foreach ($translationData as $field => $value) {
                    if ($this->isFieldTranslatable($field)) {
                        $translations[$field][$language] = $value;
                    } else {
                        $translations[$field] = $value;
                    }
                }
            } catch (TmdbApiException $e) {
            }
        }

        return $translations;
    }

    /**
     * @throws \Tmdb\Exception\TmdbApiException
     */
    public function translate(int $id, string $language): array
    {
        return $this->screenplayFetcher->findById($id, compact('language'));
    }
}
