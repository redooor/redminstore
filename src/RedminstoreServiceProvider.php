<?php

namespace Redooor\Redminstore;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Redooor\Redminstore\App\Classes\Redminstore;

class RedminstoreServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'redminstore');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'redminstore');

        Inertia::setRootView('redminstore::app');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/redooor/redminstore'),
        ], 'redminstore-views');

        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/redooor/redminstore'),
        ], 'redminstore-public');
    }

    public function register(): void
    {
        $this->app->singleton('redminstore', fn () => new Redminstore());
    }
}
