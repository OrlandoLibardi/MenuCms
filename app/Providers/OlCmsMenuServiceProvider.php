<?php 

namespace OrlandoLibardi\MenuCms\app\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

use OrlandoLibardi\MenuCms\app\Menu;
use OrlandoLibardi\MenuCms\app\Obervers\MenuObserver;

use OrlandoLibardi\MenuCms\app\MenuItem;
use OrlandoLibardi\MenuCms\app\Obervers\MenuItemObserver;



class OlCmsMenuServiceProvider extends ServiceProvider{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Rotas para controllador Menu
         */
        Route::namespace('OrlandoLibardi\MenuCms\app\Http\Controllers')
               ->middleware(['web', 'auth'])
               ->prefix('admin')
               ->group(__DIR__. '/../../routes/web.php');
        /**
         * Publicar os arquivos 
         */
        $this->publishes( [
            __DIR__.'/../../database/migrations/' => database_path('migrations/'),
            __DIR__.'/../../database/seeds/' => database_path('seeds/'),
            __DIR__.'/../../resources/views/admin/' => resource_path('views/admin/'),
            __DIR__.'/../../resources/views/website/' => resource_path('views/website/'),             
        ],'config');  
        /**
         * Observer Menu
         */
        Menu::observe(MenuObserver::class);
         /**
         * Observer Menu Items
         */
        MenuItem::observe(MenuItemObserver::class);
    }
    
}