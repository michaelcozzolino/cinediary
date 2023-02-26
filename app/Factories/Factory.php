<?php

declare(strict_types=1);

namespace App\Factories;

/**
 * @template T
 */
abstract class Factory
{
    /**
     * @return T
     */
    abstract public function create();
}
