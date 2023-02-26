<?php

namespace App\Providers;

use App\Services\ContextualBinder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContextualBinder::class);
        $this->app->register(ScreenplayServiceProvider::class);
        $this->app->register(TMDBServiceProvider::class);

        if($this->app->runningUnitTests() === false) {
            $this->app->register(TMDBServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
