<?php

namespace OrlandoLibardi\MenuCms\app\Providers;

use BadMethodCallException;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\UrlGenerator;

use Log;
use OrlandoLibardi\MenuCms\app\Menu;
use OrlandoLibardi\MenuCms\app\MenuItem;


class OlCmsMenuBuilder
{
    protected $defaults;
    protected $accepted = [];
    protected $params;
    protected $host;
    /**
     * The URL generator instance.
     *
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $url;

    /**
     * Create a new form builder instance.
     *
     * @param  \Illuminate\Contracts\Routing\UrlGenerator $url
     */
    public function __construct()
    {
        $this->url = url()->current();
        $this->host = request()->getSchemeAndHttpHost();
    }

    public function show($alias=false)
    {
        if($alias==false) return $this->setError('Alias não fornecido!');
        $menu = $this->getMenu($alias);
        
        if(!$menu) return $this->setError('Nenhum resultado encontrado!');

        $items = $this->getItems($menu->id);
        $template = $this->getTemplate($menu->template);

        $activeUrl = $this->setActiveAlias();       

        return view($template, compact('items', 'activeUrl'));        

    }

    public function setError($error)
    {
        $msg = 'ERROR OlCmsMenu: ' . $error;
        Log::info( $msg );
        return "<!-- {$msg} -->";
    }
    public function getMenu($alias)
    {   
        $menu = Menu::where('alias', $alias)->first();        
        if(!empty($menu) && count($menu->items) > 0) return $menu;
        return false;
    }

    public function getItems($id)
    {
        return MenuItem::where([['menu_id', '=', $id], ['parent_id', '=' , 0]])
               ->orderBy('order_at', 'ASC')
               ->get();
    }
    public function getTemplate($template)
    {
        $location = str_replace(resource_path('views\/'), "",  config('pages.page_path') . "/menus/" . $template);
        $location = str_replace("\/", "/", $location);
        $location = str_replace("/", ".", $location);
        $location = str_replace("..", ".", $location);
        $location = str_replace(".blade.php", "", $location);
        return $location;
    }
    public function setActiveAlias()
    {
        if(!$this->url) return $this->setError(' Ao identificar url atual! ');
        if(!$this->host) return $this->setError(' Ao identificar Host atual! ');
        return str_replace($this->host, "", $this->url);
    }

    

}