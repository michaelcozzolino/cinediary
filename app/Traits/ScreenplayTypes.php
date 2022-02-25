<?php

namespace App\Traits;

trait ScreenplayTypes
{
    /**
     * Get the available models for screenplays.
     *
     * @return array
     */
    public function getScreenplayModels(): array
    {
        return config('cinediary.screenplay_models');
    }

    /**
     * Get the screenplay types of the available models
     *
     * @return array
     */
    public function getScreenplayTypes(): array
    {
        $screenplayTypes = [];
        $models = $this->getScreenplayModels();

        foreach ($models as $model) {
            $screenplayTypes[] = $model->getTable();
        }

        return $screenplayTypes;
    }
}
