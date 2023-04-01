<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

abstract class Screenplay extends Model
{
    /**
     * Get the screenplay runtime depending on if the screenplay is a movie or a series.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    abstract protected function runtime(): Attribute;

    /**
     * Get the available models for screenplays.
     *
     * @return array
     */
    public static function getModels(): array
    {
        return config('app.screenplay_types');
    }

    /**
     * Get the screenplay types of the available models.
     *
     * @return array
     */
    public static function getTypes(): array
    {
        $screenplayTypes = [];

        $models = self::getModels();

        foreach ($models as $model) {
            $screenplayTypes[] = (new $model())->getTable();
        }

        return $screenplayTypes;
    }

    abstract public function getTranslatableAttributes(): array;
}
