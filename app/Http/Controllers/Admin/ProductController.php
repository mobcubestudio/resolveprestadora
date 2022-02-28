<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOutput;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return view('admin.product.index', [
                'products' => Product::all()
            ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function relatorio(Request $request)
    {
        $o=1;

            $produto = Product::find($request->get('product'))->first()->name;


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
                                    'product_outputs.amount'
                            )
                            ->where('products.id',$request->get('product'))
                            ->orderBy('outputs.ordered_date_time','desc')
                            ->get();

            //dd($saida);
            if($o==1) {
                $pdf = PDF::loadView('admin.product.relatorio',[
                    'produto'=>$produto,
                    'pedidos'=>$pedidos
                ]);
                return $pdf->setPaper('a4')->stream('relatorio.pdf');
            } else {
                return view('admin.product.relatorio',[
                    'pedidos'=>$pedidos
                ]);
            }


    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function trash()
    {
        return view ('admin.product.trash',[
            'products' => Product::onlyTrashed()->get()
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        toastr()->success('Produto cadastrado com sucesso');

        // Image Upload
        $this->imageUpload($request, $product->id);
        return redirect()->route('admin.products');
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
                $folderPath = public_path('images/products/');
                $image_parts = explode(";base64,", $input['image-crop']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                // $file = $folderPath . uniqid() . '.png';
                $filename = $id . '.jpg';
                $file =$folderPath.$filename;
                file_put_contents($file, $image_base64);
            }
                //$msg = 'Image upload successfully.';
                //Session::flash('message', $msg );



        /*if($request->hasFile('image') && $request->file('image')->isValid()){
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = $id . "." . $extension;
            $file_decode = base64_decode()
            $file = 'images/products'.$imageName;
            //$requestImage->move(public_path('images/products'),$imageName);
            file_put_contents($file,)
        }*/

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.product.form',['product'=>$product]);
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
        $product = Product::find($id);

        //dd($id);
        $product->name = $request->input("name");
        $product->amount = $request->input("amount");
        $product->amount_alert = $request->input("amount_alert");
        $product->save();
        toastr()->success($product->name.' editado com sucesso');

        // Image Upload
        $this->imageUpload($request, $product->id);
        return redirect()->route('admin.products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //dd($product);
        $product->delete();
        toastr()->success($product->name.' movido para a lixeira.');
        return redirect()->route('admin.products');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recycle($id)
    {
        //dd($id);
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        toastr()->success($product->name.' restaurado com sucesso');
        return redirect()->route('admin.products');
    }


}
