<?php 

namespace OrlandoLibardi\MenuCms\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use OrlandoLibardi\MenuCms\app\Http\Requests\MenuRequest;
use OrlandoLibardi\MenuCms\app\Menu;
use OrlandoLibardi\MenuCms\app\MenuItem;
use OrlandoLibardi\MenuCms\app\ServiceMenu;

class MenuController extends Controller
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
     
     $menus = Menu::paginate(10);
     return view('admin.menus.index', compact('menus'));      
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        return view('admin.menus.create');       
    }
    public function show($id)
    {
      
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request) {
        

        Menu::create($request->all());

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
    public function edit($id) 
    {
       $menu = Menu::find($id);

       $template = ServiceMenu::loadTemplate($menu->template);

       return view('admin.menus.edit', compact('menu', 'template'));  

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $id) 
    {
        
        Menu::find($id)->update($request->all());

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
    public function destroy(MenuRequest $request, $id) {
        
        foreach(json_decode($request->id) as $item)
        {
            Menu::find($item)->delete();            
        }
        
        return response()
        ->json(array(
            'message' => __('messages.update_success'),
            'status'  =>  'success'
        ), 201);
    }
    /*
    * load
    */
    public function load(Request $request)
    {

    }

    
}