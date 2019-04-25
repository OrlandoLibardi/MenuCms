<?php

namespace OrlandoLibardi\MenuCms\app\Obervers;

use OrlandoLibardi\MenuCms\app\Menu;
use OrlandoLibardi\MenuCms\app\ServiceMenu as ServiceMenu;
use Log;

class MenuObserver{

    public function creating($menu)
    {
        //Generate unique alias
        $menu->alias = Menu::alias(str_slug($menu->name, '-'), 0);
        //Generate file template
        $menu->template = ServiceMenu::save($menu->name, $menu->template);
        $menu->created_at = \Carbon\Carbon::now();
    }
    
    public function updating($menu)
    {
        $menu->template = ServiceMenu::save($menu->name, $menu->template, $menu->id);
        $menu->updated_at = \Carbon\Carbon::now();
    }


    public function deleting($menu)
    {
        Log::info("deleting". $menu->template);
        ServiceMenu::deleteTemplate($menu->template);
    }
}