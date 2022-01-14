<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    private $view_name, $name_singular, $route_name;

    public function __construct()
    {
        $this->view_name = 'client';
        $this->name_singular = 'cliente';
        $this->route_name = 'clients';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view("admin.$this->view_name.index",[
            'datas' => Client::all()
        ]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $employee = Client::create($request->all());
        toastr()->success(ucfirst($this->name_singular)." cadastrado com sucesso");

        // Image Upload
        //$this->imageUpload($request, $employee->id);
        return redirect()->route('admin.'.$this->route_name);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('admin.'.$this->view_name.'.form',['data'=>$client]);
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
        $data = Client::find($id);

        //dd($id);
        $data->cnpj = $request->input("cnpj");
        $data->name = $request->input("name");
        $data->address = $request->input("address");
        $data->number = $request->input("number");
        $data->district = $request->input("district");

        $data->save();

        toastr()->success($data->name.' editado com sucesso');

        // Image Upload
        //$this->imageUpload($request, $employee->id);
        return redirect()->route('admin.'.$this->route_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $data)
    {
        //dd($data);
        $data->delete();
        toastr()->success($data->name.' movido para a lixeira.');
        return redirect()->route('admin.'.$this->route_name);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function trash()
    {
        return view ('admin.'.$this->view_name.'.trash',[
            'datas' => Client::onlyTrashed()->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recycle($id)
    {
        //dd($id);
        $data = Client::onlyTrashed()->findOrFail($id);
        $data->restore();
        toastr()->success($data->name.' restaurado com sucesso');
        return redirect()->route('admin.'.$this->route_name);
    }
}
