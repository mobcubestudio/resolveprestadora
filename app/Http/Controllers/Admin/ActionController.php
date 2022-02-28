<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submenu;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    private $view_name, $name_singular, $route_name;

    public function __construct()
    {
        $this->view_name = 'action';
        $this->name_singular = 'ação';
        $this->route_name = 'actions';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Submenu::all();
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
        Submenu::create($request->all());
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
        return view("admin.$this->view_name.form");
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Submenu $submenu)
    {
        //ddd($submenu);
        return view("admin.$this->view_name.form",['data'=>$submenu]);
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
        $data = Submenu::find($id);

        //dd($id);
        $data->name = $request->input("name");
        $data->asset = $request->input("asset");

        $data->save();

        toastr()->success($data->name.' editado com sucesso');

        // Image Upload
        //$this->imageUpload($request, $employee->id);
        return redirect()->route('admin.'.$this->route_name);
    }
}
