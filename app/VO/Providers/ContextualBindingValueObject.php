<?php

declare(strict_types=1);

namespace App\VO\Providers;

class ContextualBindingValueObject
{
    public function __construct(
        protected array $concretes,
        protected string $abstract,
        protected \Closure|string|array $implementation,
    ) {

    }

    /**
     * @return array
     */
    public function getConcretes(): array
    {
        return $this->concretes;
    }

    /**
     * @return string
     */
    public function getAbstract(): string
    {
        return $this->abstract;
    }

    /**
     * @return array|\Closure|string
     */
    public function getImplementation(): array|\Closure|string
    {
        return $this->implementation;
    }
}
