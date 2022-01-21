<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxCotroller extends Controller
{
    public function produtosComprados(Request $request){
        $id_purchase = $request->only('id_purchase');
        //$purchase = Purchase::find($id_purchase);
        $purchases = ProductPurchase::whereHas('purchase',function ($q) use($id_purchase){
            return $q->where('purchase_id','=',$id_purchase);
        })->get();


        foreach ($purchases as $var){
            $json[] = array(
                'product'=>Product::find($var->product_id)->name,
                'amount'=>$var->amount
            );
        }
        //$pp = DB::select("SELECT * FROM product_purchases WHERE purchase_id = {$id_purchase}");
        //$json = array();

        return response()->json($json);
    }
}
