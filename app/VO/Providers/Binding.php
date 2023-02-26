<?php

declare(strict_types=1);

namespace App\VO\Providers;

class Binding
{
    /**
     * @param  class-string          $abstract
     * @param  \Closure|string|null  $concrete
     */
    public function __construct(
        public string                   $abstract,
        public \Closure|string|null $concrete = null,
    ) {

    }
}
