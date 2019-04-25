<?php 

namespace OrlandoLibardi\MenuCms\app\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;


class OlCmsMenuviewServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {               
        $this->registerOlCmsMenuBuilder();
        $this->app->alias('OlCmsMenu', OlCmsMenuBuilder::class);        
    }

    /**
     * Register the OlCmsMenu builder instance.
     */
    protected function registerOlCmsMenuBuilder()
    {
        $this->app->singleton('OlCmsMenu', function ($app) {
            return new OlCmsMenuBuilder();
        });
    }    

    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return ['OlCmsMenu', OlCmsMenuBuilder::class];
    }
}