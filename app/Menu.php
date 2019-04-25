<?php

namespace OrlandoLibardi\MenuCms\app;

use Illuminate\Database\Eloquent\Model;
use Log;

class Menu extends Model
{
    protected $fillable = [ 'name', 'alias', 'template', 'status'];

    /**
     *  Set unique Alias 
     */
    public static function alias($alias, $count=0)
    {
        $nalias = ($count > 0) ? $alias.'-'.$count : $alias;
        $menu = Menu::where('alias', $nalias)->get();        
        if(count($menu) > 0)
            return Menu::alias($alias, $count+1);

        return $nalias;
    }

    public function items()
    {
        return $this->hasMany('OrlandoLibardi\MenuCms\app\MenuItem', 'menu_id', 'id');
    }

    /**
     * Date updated_at Accessor
     */   
    public function getUpdatedAtAttribute($value)
    {
        if($value) return \Carbon\Carbon::parse($value)->format('d/m/Y H:i:s');
    }
    /**
     * Date created_at Accessor
     */   
    public function getCreatedAtAttribute($value)
    {
        if($value) return \Carbon\Carbon::parse($value)->format('d/m/Y H:i:s');
    }
}