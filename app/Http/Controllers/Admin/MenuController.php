<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuAttach;
use App\Models\Submenu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $view_name, $name_singular, $route_name;

    public function __construct()
    {
        $this->view_name = 'menu';
        $this->name_singular = 'menu';
        $this->route_name = 'menus';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Menu::all();
//dd($data);
        return view("admin.$this->view_name.index",[
            'datas' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $menu = Menu::create($request->all());

        //ASSOCIA SUBMENU AO MENU
        $i=1;
        foreach ($request->post('submenu_id') as $submenu){
            $menu_attach = new MenuAttach;
            $menu_attach->menu()->associate($menu->id);
            $menu_attach->submenu()->associate($submenu);
            $menu_attach->order = $i;
            $menu_attach->save();
            $i++;
        }
        toastr()->success(ucfirst($this->name_singular).' cadastrado com sucesso');

        return redirect()->route('admin.'.$this->route_name);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.$this->view_name.form",[
            'list_submenus'=>Submenu::all()->whereNull('deleted_at'),
            'order'=>Menu::orderDescending()->limit(1)->get('order')
        ]);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {

        $id_menu = $menu->id;
        //$purchase = Purchase::find($id_purchase);
        $menu_attach = MenuAttach::whereHas('menu',function ($q) use($id_menu){
            return $q->where('menu_id','=',$id_menu);
        })->get();

        $submenus = null;
        foreach ($menu_attach as $var){
            $submenus[] = Submenu::find($var->submenu_id);
        }

        //ddd($submenus);
        return view("admin.$this->view_name.form",['data'=>$menu],[
            'list_submenus'=>Submenu::all()->whereNull('deleted_at'),
            'submenus'=>$submenus
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->get("id");
        $data = Menu::find($id);

        //dd($id);
        $data->name = $request->input("name");
        $data->asset = $request->input("asset");

        $data->save();

        //ASSOCIA SUBMENU AO MENU
        $i=1;
        foreach ($request->post('submenu_id') as $submenu){
            $menu_attach = new MenuAttach;
            $menu_attach->menu()->associate($id);
            $menu_attach->submenu()->associate($submenu);
            $menu_attach->order = $i;
            $menu_attach->save();
            $i++;
        }




        toastr()->success($data->name.' editado com sucesso');

        // Image Upload
        //$this->imageUpload($request, $employee->id);
        return redirect()->route('admin.'.$this->route_name);
    }
}
