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
        
        // Publish a config file
        $this->publishes([
            __DIR__.'/config/image.php' => config_path('vendor/redooor/redminstore/image.php'),
            __DIR__.'/config/auth.php' => config_path('vendor/redooor/redminstore/auth.php')
        ], 'config');
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
        
        $this->app->register('Illuminate\Html\HtmlServiceProvider');
        $this->app->register('Orchestra\Imagine\ImagineServiceProvider');
        
        $this->app->booting(function() {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Redminstore', 'Redooor\Redminstore\Facades\Redminstore');
            $loader->alias('Redminportal', 'Redooor\Redminportal\Facades\Redminportal');
            $loader->alias('Form', 'Illuminate\Html\FormFacade');
            $loader->alias('HTML', 'Illuminate\Html\HtmlFacade');
            $loader->alias('Imagine', 'Orchestra\Imagine\Facade');
        });
        
        $this->registerResources('image', 'redminstore::image');
        
        // Change Authentication model
        $this->registerResources('auth', 'auth');
    }
    
    /**
     * Register the package resources.
     *
     * @return void
     */
    protected function registerResources($name, $setname)
    {
        $userConfigFile    = config_path('vendor/redooor/redminstore/' . $name . '.php');
        $packageConfigFile = __DIR__.'/config/' . $name . '.php';
        $config            = $this->app['files']->getRequire($packageConfigFile);

        if (file_exists($userConfigFile)) {
            $userConfig = $this->app['files']->getRequire($userConfigFile);
            $config     = array_replace_recursive($config, $userConfig);
        }

        $this->app['config']->set($setname, $config);
    }
}
