<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Exceptions\InvalidModelClassNameException;
use Illuminate\Database\Eloquent\Model;

class ModelHelper
{
    /**
     * Get the table name of a {@see Model}.
     *
     * @throws InvalidModelClassNameException
     */
    public static function getTable(string $modelClass): string
    {
        $model = new $modelClass();

        if ($model instanceof Model) {
            return $model->getTable();
        }

        throw new InvalidModelClassNameException(
            sprintf('The class %s is not a %s instance when instantiated', $modelClass, Model::class)
        );
    }
}
