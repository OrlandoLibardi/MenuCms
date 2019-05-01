<?php

use Illuminate\Database\Seeder;
use OrlandoLibardi\PageCms\app\Page;
use OrlandoLibardi\OlCms\AdminCms\app\Admin;

class MenuAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {               
       Admin::create([
            'name' => 'Menus',
            'route' => 'menu.index',
            'icon' => 'fa fa-list',
            'parent_id' => 0,
            'minimun_can' => 'list',
            'order_at' => 5
        ]);     

    }
}

