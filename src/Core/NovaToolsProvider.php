<?php

namespace FF\NovaTools\Core;

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class NovaToolsProvider extends ServiceProvider
{
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-extension', __DIR__ . '/../../nova-components/dist/main.js');
            Nova::style('nova-extension', __DIR__ . '/../../nova-components/dist/style.css');
        });
    }

    public function register()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/nova-api.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'domain' => config('nova.domain', null),
            'as' => 'nova.api.',
            'prefix' => 'nova-api',
            'middleware' => 'nova:api',
            'excluded_middleware' => [SubstituteBindings::class],
        ];
    }
}
