<?php

namespace App\Classes\TMDB;

use App\Exceptions\ScreenplayNotTranslatableException;
use App\Models\Screenplay;
use App\Registries\FetcherRegistry;
use Illuminate\Database\Eloquent\Model;
use Tmdb\Exception\TmdbApiException;

class Translator implements TranslatorInterface
{
    public function __construct(
        protected FetcherRegistry $fetchers,
    ) {
    }

    /**
     * Get the screenplay matching the given id and translate it if possible.
     *
     * @param  class-string  $model
     * @param  int           $id
     * @param  array         $languages
     *
     * @throws ScreenplayNotTranslatableException
     * @return Screenplay
     */
    public function firstOrTranslate(
        string $model,
        int $id,
        array $languages = [],
    ): Screenplay {
        /** @var Model $model */
        return $model::findOr(
            $id,
            function () use ($id, $model, $languages) {

                $screenplayTranslations = $this->getTranslations(new $model(), $id, $languages);

                if ($screenplayTranslations === []) {
                    throw new ScreenplayNotTranslatableException(
                        sprintf(
                            'screenplay of type %s with id #%u cannot be translated.',
                            $model::class,
                            $id
                        )
                    );
                }

                return new $model($screenplayTranslations);
            }
        );
    }

    protected function getTranslations(Screenplay $screenplayModel, int $id, array $languages = []): array
    {
        if ($languages === []) {
            $languages = config('app.available_locales');
        }

        $translations = [];

        foreach ($languages as $language) {
            try {
                $translationData = $this->translate($screenplayModel::class, $id, $language);
                foreach ($translationData as $field => $value) {
                    if ($this->isFieldTranslatable($field, $screenplayModel)) {
                        $translations[$field][$language] = $value;
                    } else {
                        $translations[$field] = $value;
                    }
                }
            } catch (TmdbApiException $e) {
                /** TODO: catch */
            }
        }

        return $translations;
    }

    protected function isFieldTranslatable(string $field, Screenplay $screenplayModel): bool
    {
        return in_array(
            $field,
            $screenplayModel->getTranslatableAttributes(),
            true
        );
    }

    /**
     * @param  class-string  $model
     * @param  int           $id
     * @param  string        $language
     *
     * @throws \App\Exceptions\RegistryNotFoundException
     * @throws \Tmdb\Exception\TmdbApiException
     * @return array
     */
    public function translate(string $model, int $id, string $language): array
    {
        return $this->fetchers->get($model)->fetchById($id, compact('language'));
    }
}
