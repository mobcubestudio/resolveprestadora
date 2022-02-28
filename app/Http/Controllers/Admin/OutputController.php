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
use Illuminate\Support\Facades\Auth;

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
            'employees' => Employee::all()->whereNull('deleted_at'),
            'titulo_pagina'=>'',
            'campo_data'=>'ordered_date_time'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitados()
    {
        $data = Output::where('status','P')->get()->sortByDesc('created_at');
        //dd($data->keys('id'));
        return view("admin.$this->view_name.index",[
            'datas' => $data,
            'employees' => Employee::all()->whereNull('deleted_at'),
            'titulo_pagina'=>'Solicitados',
            'campo_data'=>'ordered_date_time'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rota()
    {
        $data = Output::where('status','R')->get()->sortByDesc('created_at');
        //dd($data->keys('id'));
        return view("admin.$this->view_name.index",[
            'datas' => $data,
            'employees' => Employee::all()->whereNull('deleted_at'),
            'titulo_pagina'=>'em Rota',
            'campo_data'=>'sent_date_time'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function separados()
    {
        $data = Output::where('status','S')->get()->sortByDesc('created_at');
        //dd($data->keys('id'));
        return view("admin.$this->view_name.index",[
            'datas' => $data,
            'employees' => Employee::all()->whereNull('deleted_at'),
            'titulo_pagina'=>'Separados',
            'campo_data'=>'selected_date_time'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function entregues()
    {
        $data = Output::where('status','E')->get()->sortByDesc('created_at');
        //dd($data->keys('id'));
        return view("admin.$this->view_name.index",[
            'datas' => $data,
            'employees' => Employee::all()->whereNull('deleted_at'),
            'titulo_pagina'=>'Entregues',
            'campo_data'=>'received_date_time'
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



    public function action(Request $request){
        $id = $request->post('id');

        $output = Output::find($id);

        switch ($request->post('action_output')){
            case 'separar':
                $employee = Auth::user()->employee->id;
                $output->selected_by = $employee;
                $output->selected_date_time = date_create();
                $output->status = 'S';
                $output->save();
                toastr()->success(' Pedido separado com sucesso.');
                return redirect()->route('admin.outputs.request');
            break;
            case 'rota':
                $employee = Auth::user()->employee->id;
                $output->sent_by = $employee;
                $output->sent_date_time = date_create();
                $output->status = 'R';
                $output->save();
                toastr()->success('Pendido enviado para rota de entrega.');
                return redirect()->route('admin.outputs.separated');
            break;
            case 'finalizar':

                $employee = $request->post('recebido_por');
                $output->received_by = $employee;
                $output->received_notes = $request->post('recebido_anotacoes');
                $output->received_date_time = date_create();
                $output->status = 'E';
                $output->save();

                //RETIRANDO PRODUTOS DO ESTOQUE
                foreach($output->productOutput as $pdtOut){
                    $pdt = $pdtOut->product;
                    $qtd_atual = ($pdt->amount + 0);
                    $pdt->amount = ($qtd_atual - $pdtOut->amount) + 0;
                    $pdt->save();
                }


                toastr()->success(' Pedido separado com sucesso.');
                return redirect()->route('admin.outputs.route');
            break;
        }


    }


}
