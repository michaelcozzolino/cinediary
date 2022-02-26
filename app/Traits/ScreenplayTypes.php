<?php

namespace App\Traits;

use App\Models\Movie;
use App\Models\Series;

trait ScreenplayTypes
{
    /**
     * Get the available models for screenplays.
     *
     * @return array
     */
    public function getScreenplayModels(): array
    {
        return [new Movie(), new Series()];
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
