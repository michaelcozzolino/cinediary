<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\App;

class ContextualBindingValueObject
{
    public function __construct(
        protected array                 $concretes,
        protected string                $abstract,
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

class ContextualBinder
{
    public function bindOne(ContextualBindingValueObject $contextualBindingValueObject): self
    {
        App::when($contextualBindingValueObject->getConcretes())
           ->needs($contextualBindingValueObject->getAbstract())
           ->give($contextualBindingValueObject->getImplementation());

        return $this;
    }

    /**
     * @param  array<ContextualBindingValueObject>  $contextualBindings
     *
     * @return void
     */
    public function bindMany(array $contextualBindings)
    {
        foreach ($contextualBindings as $contextualBinding) {
            $this->bindOne($contextualBinding);
        }
    }
}
