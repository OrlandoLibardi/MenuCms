<?php

namespace OrlandoLibardi\MenuCms\app;

use Illuminate\Database\Eloquent\Model;
use Log;

class MenuItem extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'menu_id', 'parent_id', 'title', 'url', 'target', 'order_at'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function childs()
    {
        return $this->hasMany('OrlandoLibardi\MenuCms\app\MenuItem', 'parent_id', 'id');
    }


    public function menu()
    {
        return $this->hasOne('OrlandoLibardi\MenuCms\app\Menu', 'id', 'menu_id');
    }

    public function scopeItems($q, $menu_id)
    {
        return $q->where([['menu_id', '=', $menu_id], ['parent_id', '=', 0]]);

    }

    public static function maxOrder($menu_id, $parent_id)
    {
        $q = MenuItem::where([['menu_id', '=', $menu_id], ['parent_id', '=', $parent_id]])
             ->orderBy('order_at', 'DESC')
             ->first();
        if($q) return $q->order_at + 1;        
        return 1;    
    }

    public static function parents($id, $menu_id)
    {
        return MenuItem::where([['id', '!=', $id], ['menu_id', '=', $menu_id]])->orderBy('order_at', 'DESC')->get();
    }

    
}