<?php namespace Redooor\Redminstore;

use Illuminate\Support\ServiceProvider;

class RedminstoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Get routes
        include __DIR__.'/App/Http/routes.php';
        
        // Get views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'redminstore');
        
        // Establish Translator Namespace
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'redminstore');
        
        // Allow end users to publish and modify views
        $this->publishes([
            __DIR__.'/resources/views' => base_path('resources/views/vendor/redooor/redminstore'),
        ]);
        
        // Allow end users to publish and modify public assets
        $this->publishes([
            __DIR__.'/public' => public_path('vendor/redooor/redminstore'),
        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Load autoload for package development environment only
        $autoloader = __DIR__ . '/../vendor/autoload.php';
        if (file_exists($autoloader)) {
            require_once $autoloader;
        }
        
        $this->app->register('Orchestra\Imagine\ImagineServiceProvider');
        
        $this->app->booting(function() {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Redminstore', 'Redooor\Redminstore\Facades\Redminstore');
            $loader->alias('Redminportal', 'Redooor\Redminportal\Facades\Redminportal');
            $loader->alias('Imagine', 'Orchestra\Imagine\Facade');
        });
    }
}
