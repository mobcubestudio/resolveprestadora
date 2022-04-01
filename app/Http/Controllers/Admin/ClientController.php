<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Patrimony;
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
            'datas' => Client::orderBy('name','asc')->paginate(15)
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
    public function destroy(Client $client)
    {
        //dd($data);
        $client->delete();
        toastr()->success($client->name.' movido para a lixeira.');
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
        //$id = $client->id;
        $data = Client::onlyTrashed()->findOrFail($id);
        $data->restore();
        toastr()->success($data->name.' restaurado com sucesso');
        return redirect()->route('admin.'.$this->route_name);
    }

    public function patrimonyList(Client $client){
        $data = $client;
        //dd($data->patrimony);
        return view("admin.$this->view_name.patrimony",[
            'datas' => $data->patrimony,
            'client'=> $client
        ]);

    }

    public function patrimonyAdd(Request $request){
        $client = Client::find($request->post('client_id'));
        $patrimony = new Patrimony;
        $patrimony->client()->associate($request->post('client_id'));
        $patrimony->name = $request->post('name');
        $patrimony->brand = $request->post('brand');
        $patrimony->model = $request->post('model');
        $patrimony->serial_no = $request->post('serial_no');
        $patrimony->comment = nl2br($request->post('comment'));
        $patrimony->save();
        toastr()->success(' Patrimônio cadastrado com sucesso.');
        $this->imageUpload($request, $patrimony->id);
        return redirect()->route('admin.'.$this->route_name.'.patrimony.list',['client'=>$client]);


    }


    /**
     * Upload Image
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    private function imageUpload(Request $request, int $id)
    {
        $input = $request->all();


        if ($input['image-crop']!=null) {

            //dd($input['image-crop']);
            $folderPath = public_path('images/patrimonies/');
            $image_parts = explode(";base64,", $input['image-crop']);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            // $file = $folderPath . uniqid() . '.png';
            $filename = $id . '.jpg';
            $file =$folderPath.$filename;
            file_put_contents($file, $image_base64);
        }

    }
}
