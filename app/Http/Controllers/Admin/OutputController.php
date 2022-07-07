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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $data = Output::orderBy('created_at','desc')->paginate(15);
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
        $data = Output::where('status','P')->orderBy('created_at','desc')->paginate(15);
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
        $data = Output::where('status','R')->orderBy('created_at','desc')->paginate(15);
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
        $data = Output::where('status','S')->orderBy('created_at','desc')->paginate(15);
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
        $data = Output::where('status','E')->orderBy('created_at','desc')->paginate(15);
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
        $output->ordered_by = Auth::user()->employee_id;
        $output->is_epi = $request->post('is_epi');
        $output->epi_employee_id = $request->post('epi_employee_id');
        $output->ordered_date_time = date_create();
        $output->status = 'P';
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
                $employee = Auth::user()->employee_id;
                $output->selected_by = $employee;
                $output->selected_date_time = date_create();
                $output->status = 'S';
                $output->save();
                toastr()->success(' Pedido separado com sucesso.');
                return redirect()->route('admin.outputs.request');
            break;
            case 'rota':
                $employee = Auth::user()->employee_id;
                $output->sent_by = $employee;
                $output->sent_date_time = date_create();
                $output->status = 'R';
                $output->save();

                //RETIRANDO PRODUTOS DO ESTOQUE
                foreach($output->productOutput as $pdtOut){
                    $pdt = $pdtOut->product;
                    $qtd_atual = ($pdt->amount + 0);
                    $pdt->amount = ($qtd_atual - $pdtOut->amount) + 0;
                    $pdt->save();
                }

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

                toastr()->success(' Pedido separado com sucesso.');
                return redirect()->route('admin.outputs.route');
            break;
        }


    }

    /**
     * Gera PDF da Ordem de serviço
     * @param Request $request (ID OUTPUT)
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function ordem(Request $request)
    {
        $o=1;

        $pedido = Output::where('id','=',$request->get('output'))->first();
        $cliente = $pedido->client->name;
        $data_pedido = date_format(date_create($pedido->ordered_date_time),'d/m/Y H:i');
        $data_separacao = date_format(date_create($pedido->selected_date_time),'d/m/Y H:i');
        $pedido_numero = str_pad($request->get('output'),6,'0',STR_PAD_LEFT);



        $funcionario = ($pedido->is_epi == 1) ? Employee::where('id','=',$pedido->epi_employee_id)->first()->name : '';




        $pedidos = DB::table('products')
            ->join('product_outputs','products.id','product_outputs.product_id')
            ->join('outputs','product_outputs.output_id','outputs.id')
            ->join('clients','outputs.client_id','clients.id')
            ->select(
                'outputs.status',
                'outputs.ordered_date_time',
                'outputs.selected_date_time',
                'outputs.sent_date_time',
                'outputs.received_date_time',
                'outputs.ordered_by',
                'outputs.selected_by',
                'outputs.sent_by',
                'outputs.received_by',
                'outputs.received_notes',
                'clients.name as cliente',
                'products.name as produto',
                'product_outputs.amount'
            )
            ->where('outputs.id',$request->get('output'))
            ->orderBy('outputs.ordered_date_time','desc')
            ->get();

        //dd($saida);
        if($o==1) {
            $pdf = PDF::loadView('admin.output.ordem',[
                'data_pedido'=>$data_pedido,
                'data_separacao'=>$data_separacao,
                'cliente'=>$cliente,
                'pedido_numero'=>$pedido_numero,
                'pedidos'=>$pedidos,
                'funcionario'=>$funcionario

            ]);
            return $pdf->setPaper('a4')->stream('ordem_' . $pedido_numero . '.pdf');
        } else {
            return view('admin.output.ordem',[
                'data_pedido'=>$data_pedido,
                'data_separacao'=>$data_separacao,
                'cliente'=>$cliente,
                'pedido_numero'=>$pedido_numero,
                'pedidos'=>$pedidos,
                'funcionario'=>$funcionario
            ]);
        }


    }

    /**
     * Gera PDF da Ordem de serviço
     * @param Request $request (ID OUTPUT)
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function relatorio(Request $request)
    {
        $o=1;

        $pedido = Output::where('id','=',$request->get('output'))->first();
        $cliente = $pedido->client->name;
        $data_pedido = date_format(date_create($pedido->ordered_date_time),'d/m/Y H:i');
        $data_separacao = ($pedido->selected_date_time) ? date_format(date_create($pedido->selected_date_time),'d/m/Y H:i') : '';
        $data_rota = ($pedido->sent_date_time) ? date_format(date_create($pedido->sent_date_time),'d/m/Y H:i') : '';
        $data_entrega = ($pedido->received_date_time) ? date_format(date_create($pedido->received_date_time),'d/m/Y H:i') : '';

        $pedido_numero = str_pad($request->get('output'),6,'0',STR_PAD_LEFT);

        //RESPONSAVEIS
        $pedido_responsavel = Employee::find($pedido->ordered_by)->name;
        $separacao_responsavel = ($pedido->selected_by!=null) ? Employee::find($pedido->selected_by)->name : 'AGUARDANDO...';
        $rota_responsavel = ($pedido->sent_by != null) ? Employee::find($pedido->sent_by)->name : 'AGUARDANDO...';



        if($pedido->status == 'Entregue'){
            $entrega_responsavel = ($pedido->received_by) ? Employee::find($pedido->received_by)->name . '<br />' : '';
            $entrega_anotacao = ($pedido->received_notes) ? $pedido->received_notes : 'NADA FOI ANOTADO.';
        } else {
            $entrega_responsavel = 'AGUARDANDO...';
            $entrega_anotacao = '';
        }




        $funcionario = ($pedido->is_epi == 1) ? Employee::where('id','=',$pedido->epi_employee_id)->first()->name : '';




        $pedidos = DB::table('products')
            ->join('product_outputs','products.id','product_outputs.product_id')
            ->join('outputs','product_outputs.output_id','outputs.id')
            ->join('clients','outputs.client_id','clients.id')
            ->select(
                'outputs.status',
                'outputs.ordered_date_time',
                'outputs.selected_date_time',
                'outputs.sent_date_time',
                'outputs.received_date_time',
                'outputs.ordered_by',
                'outputs.selected_by',
                'outputs.sent_by',
                'outputs.received_by',
                'outputs.received_notes',
                'clients.name as cliente',
                'products.name as produto',
                'product_outputs.amount'
            )
            ->where('outputs.id',$request->get('output'))
            ->orderBy('outputs.ordered_date_time','desc')
            ->get();

        //dd($saida);
        if($o==1) {
            $pdf = PDF::loadView('admin.output.relatorio',[
                'data_pedido'=>$data_pedido,
                'data_separacao'=>$data_separacao,
                'data_rota'=>$data_rota,
                'data_entrega'=>$data_entrega,
                'cliente'=>$cliente,
                'pedido_numero'=>$pedido_numero,
                'pedidos'=>$pedidos,
                'pedido_responsavel'=>$pedido_responsavel,
                'separacao_responsavel'=>$separacao_responsavel,
                'rota_responsavel'=>$rota_responsavel,
                'entrega_responsavel'=>$entrega_responsavel,
                'entrega_anotacao'=>$entrega_anotacao

            ]);
            return $pdf->setPaper('a4')->stream('ordem_' . $pedido_numero . '.pdf');
        } else {
            return view('admin.output.relatorio',[
                'data_pedido'=>$data_pedido,
                'data_separacao'=>$data_separacao,
                'cliente'=>$cliente,
                'pedido_numero'=>$pedido_numero,
                'pedidos'=>$pedidos

            ]);
        }


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Output $output)
    {
        //dd($data);
        $output->delete();
        toastr()->success('Pedido #' . $output->id . ' movido para a lixeira.');
        return redirect()->route('admin.'.$this->route_name);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function trash()
    {
        return view ('admin.'.$this->view_name.'.trash',[
            'datas' => Output::onlyTrashed()->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recycle($id)
    {
        //dd($id);
        $data = Output::onlyTrashed()->findOrFail($id);
        $data->restore();
        toastr()->success('Pedido #' . $data->id.' restaurado com sucesso');
        return redirect()->route('admin.'.$this->route_name);
    }

}
