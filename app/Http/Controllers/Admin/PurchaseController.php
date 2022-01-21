<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Provider;
use App\Models\Purchase;
use App\Models\xProductPurchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    private $view_name, $name_singular, $route_name;

    public function __construct()
    {
        $this->view_name = 'purchase';
        $this->name_singular = 'compra';
        $this->route_name = 'purchases';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Purchase::with('employee')->orderBy('created_at','desc')->get();
//dd($data);
        return view("admin.$this->view_name.index",[
            'datas' => $data
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
            'list_providers'=>Provider::all()->whereNull('deleted_at'),
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
        $source = array('.', ',');
        $replace = array('', '.');
        $price = str_replace($source, $replace, $request->post('price'));
        //dd($request->post('product_id'));



        $data = $request->all();
        $data['price'] = $price;

        //CADASTRANDO VENDA
        $purchase = new Purchase;
        $purchase->price = $price;
        $purchase->employee()->associate($request->post('employee_id'));
        $purchase->provider()->associate($request->post('provider_id'));
        $purchase->save();

        //RELACIONANDO PRODUTOS ÀS VENDAS
        $i=0;
        //dd($request->post('product_id'));
        foreach ($request->post('product_id') as $product){

            $product_purchase = new ProductPurchase;
            $product_purchase->purchase()->associate($purchase->id);
            $product_purchase->product()->associate($product);
            $product_purchase->amount = $request->post('amount')[$i];
            $product_purchase->save();

            //ADICIONANDO QUANTIDADE AO ESTOQUE
            $product_add = Product::find($product);
            $product_add->amount = $product_add->amount + $request->post('amount')[$i];
            $product_add->save();


            //dd($product);
            $i++;
        }


        //dd($purchase);
        toastr()->success(ucfirst($this->name_singular)." cadastrado com sucesso");

        // Image Upload
        //$this->imageUpload($request, $employee->id);
        return redirect()->route('admin.'.$this->route_name);
    }



}
