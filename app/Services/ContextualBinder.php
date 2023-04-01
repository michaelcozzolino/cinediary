<?php

declare(strict_types=1);

namespace App\Services;

use App\VO\Providers\ContextualBindingValueObject;
use Illuminate\Support\Facades\App;

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
