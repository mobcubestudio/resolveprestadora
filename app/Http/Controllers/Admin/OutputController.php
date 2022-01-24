<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Output;
use App\Models\Product;
use App\Models\ProductOutput;
use App\Models\ProductPurchase;
use App\Models\Provider;
use App\Models\Purchase;
use App\Models\xProductPurchase;
use Illuminate\Http\Request;

class OutputController extends Controller
{
    private $view_name, $name_singular, $route_name;

    public function __construct()
    {
        $this->view_name = 'output';
        $this->name_singular = 'pedido';
        $this->route_name = 'outputs';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Output::all()->sortByDesc('created_at');
        //dd($data->keys('id'));
        return view("admin.$this->view_name.index",[
            'datas' => $data,
            'employees' => Employee::all()->whereNull('deleted_at')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.$this->view_name.form",[
            'list_employees'=>Employee::all()->whereNull('deleted_at'),
            'list_clients'=>Client::all()->whereNull('deleted_at'),
            'list_products'=>Product::all()->whereNull('deleted_at')
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

        $data = $request->all();

        //CADASTRANDO PEDIDO
        $output = new Output();
        $output->ordered_by = $request->post('ordered_by');
        $output->ordered_date_time = date_create();
        $output->client()->associate($request->post('client_id'));
        $output->save();

        //RELACIONANDO PRODUTOS AO PEDIDO
        $i=0;
        //dd($request->post('product_id'));
        foreach ($request->post('product_id') as $product){

            $product_output = new ProductOutput;
            $product_output->output()->associate($output->id);
            $product_output->product()->associate($product);
            $product_output->amount = $request->post('amount')[$i];
            $product_output->save();


            //dd($product);
            $i++;
        }


        //dd($purchase);
        toastr()->success(ucfirst($this->name_singular)." cadastrado com sucesso");

        // Image Upload
        //$this->imageUpload($request, $employee->id);
        return redirect()->route('admin.'.$this->route_name);
    }



    public function separate(Request $request){
        $id = $request->post('id');
        $employee = $request->post('employee');
        $output = Output::find($id);
        $output->sent_by = $employee;
        $output->sent_date_time = date_create();
        $output->status = 'S';
        $output->save();

        toastr()->success(' Pedido separado com sucesso.');
        return redirect()->route('admin.outputs');
    }


}
