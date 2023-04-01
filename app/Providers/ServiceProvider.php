<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\ContextualBinder;
use App\VO\Providers\Binding;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

abstract class ServiceProvider extends BaseServiceProvider
{
    protected ContextualBinder $contextualBinder;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->contextualBinder = new ContextualBinder();
    }

    /**
     * @param  array<Binding>  $singletons
     *
     * @return void
     */
    public function registerSingletons(array $singletons): void
    {
        foreach ($singletons as $singleton) {
            $this->singleton($singleton);
        }
    }

    protected function singleton(Binding $binding): void
    {
        $this->app->singleton($binding->abstract, $binding->concrete);
    }
}
