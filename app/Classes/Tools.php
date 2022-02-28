<?php

namespace App\Classes;


use App\Models\Action;
use App\Models\ActionPermission;
use App\Models\Menu;
use App\Models\MenuPermission;
use App\Models\Submenu;
use App\Models\SubmenuPermission;
use App\Models\User;
use GuzzleHttp\Psr7\UriResolver;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class Tools
{
    public function __construct()
    {
        $this->sessionMenu();
    }

    public function sessionMenu()
    {



            $url = URL::current();
            $isola_parametros = substr($url,strpos($url,'admin')+6);
            //$conta_barras = str_word_count($isola_parametros,0);


            $separa_parametros = explode('/',$isola_parametros);

            dd($separa_parametros[0]);


            if($separa_parametros[0]!='busca'){
                $menu_find = Menu::where('asset',$separa_parametros[0])->get();

                Session::put('menu_id',$menu_find->First()->id);
                Session::put('menu_model',$menu_find->First()->model);
                Session::put('menu_class',$menu_find->First()->class);
                Session::put('menu_nome',$separa_parametros[0]);
                Session::put('menu_busca',$menu_find->First()->search);
                Session::put('menu_busca_placeholder',$menu_find->First()->search_placeholder);
            }






            if(isset($separa_parametros[1]) && $separa_parametros[1]!=''){
                //dd($separa_parametros);
                $submenu_find = Submenu::where('asset',$separa_parametros[1])->get();
                Session::put('submenu_id',$submenu_find->First()->id);
                Session::put('submenu_nome',$separa_parametros[1]);
            } else {
                if(count($separa_parametros)==1){
                    Session::put('submenu_id',1);
                    Session::put('submenu_nome','Listar');
                } else {
                    Session::remove('submenu_id');
                    Session::remove('submenu_nome');
                }

            }
            //Session::put('submenu_id',$submenu_id);
            //dd(Session::all());

    }

    public function sessionUser($user_id)
    {
        Session::put('user_id',$user_id);
    }

    public function montaMenu(){

        $user_id = Auth::user()->id;

        $menus_originais = Menu::all();
        foreach ($menus_originais as $menus_original){
            $menu_index[$menus_original->id] = [
                'id'=>$menus_original->id,
                'nome'=>$menus_original->name,
                'url'=>$menus_original->asset
            ];
        }

        $submenus_originais = Submenu::all();
        foreach ($submenus_originais as $submenus_original){
            $submenu_index[$submenus_original->id] = [
                'id'=>$submenus_original->id,
                'nome'=>$submenus_original->name,
                'url'=>$submenus_original->asset,
                'divisor'=>$submenus_original->divisor
            ];
        }



        $menus = MenuPermission::where('user_id',$user_id)->get();
        //dd($menu_index);


        echo '<nav class="navbar navbar-expand-lg navbar-light bg-black bg-opacity-10">';
        echo '<div class="container-fluid">';
        echo '<a class="navbar-brand" href="#"></a>';
        echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
        echo '<span class="navbar-toggler-icon"></span>';
        echo '</button>';
        echo '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
        echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0">';

        foreach ($menus as $menu){

            echo '<li class="nav-item dropdown">';
            echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
            echo $menu_index[$menu->menu_id]['nome'];
            echo '</a>';

            $submenus = SubmenuPermission::where('user_id',$user_id)->where('menu_id',$menu->menu_id)->get();
            echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
            foreach ($submenus as $submenu){
                if($submenu_index[$submenu->submenu_id]['divisor']=='S')
                    echo '<li><hr class="dropdown-divider"></li>';
                echo '<li><a class="dropdown-item" href="' . asset(  'admin/' . $menu_index[$menu->menu_id]['url'] . '/' . $submenu_index[$submenu->submenu_id]['url'] ). '">' . $submenu_index[$submenu->submenu_id]['nome'] . '</a></li>';
            }

            echo '</ul>';


            echo '</li>';

        }
        echo '</ul>';


        if(Session::get('menu_busca') && Session::get('menu_busca')=='S'){
            echo '<form class="d-flex" method="post" action="' . route('admin.busca') . '"  enctype="multipart/form-data">';
            echo '<input type="hidden" name="_token" value="' . @csrf_token() . '">';
            echo '<input class="form-control me-2" required name="busca" type="search" placeholder="' . Session::get('menu_busca_placeholder') . '" aria-label="Search">';
            echo '<button class="btn btn-outline-success" type="submit">Procurar</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
        echo '</nav>';

    }

    public function montaAcoes($var){



        $user_id = Auth::user()->id;
        $menu_id = Session::get('menu_id');
        $menu_model = Session::get('menu_model');
        $menu_class = Session::get('menu_class');
        $submenu_id = Session::get('submenu_id');

        //dd();

        $acoes_originais = Action::all();
        foreach ($acoes_originais as $acao_original){
            $acoes_index[$acao_original->id] = [
                'id'=>$acao_original->id,
                'nome'=>$acao_original->name,
                'icon'=>$acao_original->icon,
                'class'=>$acao_original->class,
                'extra'=>$acao_original->extra,
                'on_click'=>$acao_original->on_click,
                'url'=>$acao_original->route,
                'href_disable'=>$acao_original->href_disable,
                'identification'=>$acao_original->identification
            ];
        }

        $acoes = ActionPermission::where('user_id',$user_id)->where('menu_id',$menu_id)->where('submenu_id',$submenu_id)->get();
        foreach ($acoes as $acao){
            $href = ($acoes_index[$acao->action_id]['href_disable'] == 'N') ? 'href="' . route("admin.$menu_model.{$acoes_index[$acao->action_id]['url']}",$var) . '"' : '';
            echo '<a id="' . $acoes_index[$acao->action_id]['identification'] . '" class="icon-action ' . $acoes_index[$acao->action_id]['class'] . '" data-id="' . $var[$menu_class]->id . '" data-extra="' . $acoes_index[$acao->action_id]['extra'] . '" onclick="' . $acoes_index[$acao->action_id]['on_click'] . '" style="margin-right: 1em" ' . $href . ' data-bs-toggle="tooltip" data-bs-placement="top" title="' . $acoes_index[$acao->action_id]['nome'] . '">';
            echo '<svg class="bi" width="1.5em" height="1.5em" fill="currentColor">';
            echo '<use xlink:href="' . asset('images/actions/bootstrap-icons.svg') . '#' . $acoes_index[$acao->action_id]['icon'] . '"></use>';
            echo '</svg>';
            echo '</a>';
        }

    }


}
