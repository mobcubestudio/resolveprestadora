<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Menu;
use App\Models\Output;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Submenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BuscaController extends Controller
{
    public function index(Request $request)
    {
        Session::flash('busca_por',$request->input('busca'));

        //dd($request);
        switch (Session::get('menu_class')){
            case 'product':
                return view('admin.product.index', ['products' => Product::where('name','like', '%' . $request->input('busca') . '%')->orderBy('name','asc')->paginate(15)],['busca_por'=>$request->input('busca')]);
            break;
            case 'employee':
                return view('admin.employee.index', ['employees' => Employee::where('name','like', '%' . $request->input('busca') . '%')->orderBy('name','asc')->paginate(15)],['busca_por'=>$request->input('busca')]);
            break;
            case 'client':
                return view('admin.client.index', ['datas' => Client::where('name','like', '%' . $request->input('busca') . '%')->orderBy('name','asc')->paginate(15)],['busca_por'=>$request->input('busca')]);
            break;
            case 'provider':
                return view('admin.provider.index', ['datas' => Provider::where('name','like', '%' . $request->input('busca') . '%')->orderBy('name','asc')->paginate(15)],['busca_por'=>$request->input('busca')]);
            break;
            /*case 'output':
                return view('admin.output.index', ['datas' => Output:: where('name','like', '%' . $request->input('busca') . '%')->orderBy('name','asc')->paginate(15)],['busca_por'=>$request->input('busca')]);
            break;*/
            case 'menu':
                return view('admin.menu.index', ['datas' => Menu::where('name','like', '%' . $request->input('busca') . '%')->get()],['busca_por'=>$request->input('busca')]);
            break;
            case 'submenu':
                return view('admin.submenu.index', ['datas' => Submenu::where('name','like', '%' . $request->input('busca') . '%')->get()],['busca_por'=>$request->input('busca')]);
            break;
        }



    }
}
