<?php

namespace App\Providers;

use App\Services\ScreenplayContextService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class ScreenplayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::enforceMorphMap(ScreenplayContextService::getAvailableTypes());
    }
}
