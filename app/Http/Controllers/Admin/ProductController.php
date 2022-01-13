<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('admin.product.index',[
            'products' => Product::all()
        ]);
    }

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
        return back();
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


            if ($input['image-crop'] || $input['image-crop'] != '0') {

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.product.show', ['id'=>$id]);
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
    public function form(Request $request)
    {


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
        return back();
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


    public function recycle($id)
    {
        //dd($id);
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        toastr()->success($product->name.' restaurado com sucesso');
        return redirect()->route('admin.products');
    }


}
