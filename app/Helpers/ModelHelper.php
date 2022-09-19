<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class ModelHelper
{
    public static function getTable(string $class): string
    {
        $model = new $class();

        if ($model instanceof Model) {
            return $model->getTable();
        }

        return '';
    }
}
