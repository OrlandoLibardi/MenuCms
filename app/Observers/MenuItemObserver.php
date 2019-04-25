<?php

namespace OrlandoLibardi\MenuCms\app\Obervers;

use OrlandoLibardi\MenuCms\app\MenuItem;
use Log;

class MenuItemObserver{

    public function creating($item)
    {
        

        if(empty($item->parent_id)) 
        {
            $item->parent_id = 0;
        }

        if(empty($item->order_at)) 
        {
            $item->order_at = MenuItem::maxOrder($item->menu_id, $item->parent_id);
        }

        $item->type = 0;
    }
    
    public function updating($item)
    {
        if(empty($item->parent_id) || $item->parent_id == $item->id)
        {
            $item->parent_id = 0;
        }
        
        $item->type = 0;
    }
}