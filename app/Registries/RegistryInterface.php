<?php

declare(strict_types=1);

namespace App\Registries;

use App\Exceptions\RegistryNotFoundException;
use Exception;

/**
 * @template T
 */
interface RegistryInterface
{
    /**
     * @param  string  $name
     * @param  T         $instance
     *
     * @return self
     */
    public function register(string $name, $instance): self;

    public function registerMany(array $data): self;

    /** todo: add more info to exception.
     * @param  string  $name
     *
     * @throws RegistryNotFoundException
     * @return T
     */
    public function get(string $name);
}
