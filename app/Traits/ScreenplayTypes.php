<?php

namespace App\Traits;

trait ScreenplayTypes{

    public function getScreenplayModels(): array {
        return config('cinediary.screenplay_models');
    }

    public function getScreenplayTypes(): array {
        $screenplayTypes = [];
        $models = $this->getScreenplayModels();

        foreach ($models as $model)
            $screenplayTypes []= $model->getTable();

        return $screenplayTypes;
    }
}
