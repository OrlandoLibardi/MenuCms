<?php 

namespace OrlandoLibardi\MenuCms\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use OrlandoLibardi\MenuCms\app\Http\Requests\MenuItemRequest;

use OrlandoLibardi\MenuCms\app\Menu;
use OrlandoLibardi\PageCms\app\Page;
use OrlandoLibardi\MenuCms\app\MenuItem;

class MenuItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list');
        $this->middleware('permission:create', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:delete', ['only' => ['destroy']]);                
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {  
                
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
          
    }
    public function show($alias)
    {
      $menu  = Menu::where('alias', $alias)->first();
      $pages = Page::select('id', 'name', 'alias')->orderBy('name','ASC')->get();
      $items = MenuItem::items($menu->id)
               ->orderBy('order_at', 'ASC')
               ->get();
               
       return view('admin.menus.items.index', compact('menu', 'items', 'pages'));         
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuItemRequest $request) {
        
        MenuItem::create( $request->all() );

        return response()
        ->json(array(
            'message' => __('messages.create_success'),
            'status'  =>  'success'
        ), 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id) 
    {
       $selected = MenuItem::find($id);
       $pages = Page::select('id', 'name', 'alias')->orderBy('name','ASC')->get();       
       $items = MenuItem::items($selected->menu->id)
                ->orderBy('order_at', 'ASC')
                ->get();

       return view('admin.menus.items.edit', compact('selected', 'pages', 'items'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuItemRequest $request, $id) 
    {
        MenuItem::find($id)
                 ->update( $request->all() );

        return response()
        ->json(array(
            'message' => __('messages.update_success'),
            'status'  =>  'success'
        ), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function reOrder(MenuItemRequest $request) 
    {
        MenuItem::find( $request->id )
                ->update(['order_at' => $request->order ]);

        return response()
        ->json(array(
            'message' => __('messages.update_success'),
            'status'  =>  'success'
        ), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItemRequest $request, $id) {

        foreach(json_decode($request->id) as $item)
        {
            MenuItem::find($item)->delete();            
        }

        return response()
        ->json(array(
            'message' => __('messages.destroy_success'),
            'status'  =>  'success'
        ), 201);
    }
    

    
}