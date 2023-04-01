<?php

declare(strict_types=1);

namespace App\Registries;

use App\Exceptions\RegistryNotFoundException;
use Exception;

/**
 * @template T
 */
class Registry implements RegistryInterface
{
    /**
     * @var array<string, T>
     */
    protected array $instances = [];

    /**
     * @inheritDoc
     */
    public function register(string $name, $instance): self
    {
        if (array_key_exists($name, $this->instances)) {
            throw new Exception('cannot reinstanciate');
        }

        $this->instances[$name] = $instance;

        return $this;
    }

    public function registerMany(array $data): self
    {
        foreach ($data as $name => $instance) {
            $this->register($name, $instance);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $name)
    {
        if (in_array($name, array_keys($this->instances))) {
            return $this->instances[$name];
        } else {
            throw new RegistryNotFoundException(
                sprintf('Registry with name %s not found', $name)
            );
        }
    }

    /**
     * @return array<string, T>
     */
    public function getInstances(): array
    {
        return $this->instances;
    }
}
