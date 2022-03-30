<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::namespace('Site')->group(function (){
    Route::get('/','\App\Http\Controllers\Site\HomeController')->name('site.home');
});

    Route::get('/admin/login','\App\Http\Controllers\Admin\AuthController@loginForm')->name('admin.login');
    Route::post('/admin/login/do','\App\Http\Controllers\Admin\AuthController@login')->name('admin.login.do');
    Route::get('/admin/logout','\App\Http\Controllers\Admin\AuthController@logout')->name('admin.logout');

    Route::group(['middleware'=>['auth']], function (){
        Route::get('/admin','\App\Http\Controllers\Admin\HomeController@index')->name('admin.home');

        //MEUS DADOS
        Route::get('/admin/profiles/password','\App\Http\Controllers\Admin\ProfileController@alterarSenha')->name('admin.profiles.password.alter');
        Route::post('/admin/profiles/password/do','\App\Http\Controllers\Admin\ProfileController@alterarSenhaDo')->name('admin.profiles.password.alter.do');

        //BUSCA
        Route::post('/admin/busca','\App\Http\Controllers\Admin\BuscaController@index')->name('admin.busca');

        ////// DEV /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //MENUS
        Route::get('/admin/menus/listar','\App\Http\Controllers\Admin\MenuController@index')->name('admin.menus');
        //Route::get('/admin/compras/lixo','\App\Http\Controllers\Admin\PurchaseController@trash')->name('admin.purchases.trash');
        Route::get('/admin/menus/form','\App\Http\Controllers\Admin\MenuController@create')->name('admin.menus.form.create');
        Route::post('/admin/menus/create','\App\Http\Controllers\Admin\MenuController@store')->name('admin.menus.action.create');
        Route::get('/admin/menus/listar/form/{menu}','\App\Http\Controllers\Admin\MenuController@edit')->name('admin.menus.form.edit');
        Route::post('/admin/menus/update','\App\Http\Controllers\Admin\MenuController@update')->name('admin.menus.action.update');

        //SUBMENUS
        Route::get('/admin/submenus/listar','\App\Http\Controllers\Admin\SubmenuController@index')->name('admin.submenus');
        //Route::get('/admin/compras/lixo','\App\Http\Controllers\Admin\PurchaseController@trash')->name('admin.purchases.trash');
        Route::get('/admin/submenus/form','\App\Http\Controllers\Admin\SubmenuController@create')->name('admin.submenus.form.create');
        Route::post('/admin/submenus/create','\App\Http\Controllers\Admin\SubmenuController@store')->name('admin.submenus.action.create');
        Route::get('/admin/submenus/listar/form/{submenu}','\App\Http\Controllers\Admin\SubmenuController@edit')->name('admin.submenus.form.edit');
        Route::post('/admin/submenus/update','\App\Http\Controllers\Admin\SubmenuController@update')->name('admin.submenus.action.update');
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




        //AJAX
        Route::post('ajax/produtos_comprados',['as'=>'admin.ajax.produtos_comprados', 'uses'=>'\App\Http\Controllers\Admin\AjaxCotroller@produtosComprados']);
        Route::post('ajax/separar_produtos_lista',['as'=>'admin.ajax.separar_produtos.lista', 'uses'=>'\App\Http\Controllers\Admin\AjaxCotroller@separarProdutosLista']);
        Route::post('ajax/separar_produtos_submit',['as'=>'admin.ajax.separar_produtos.submit', 'uses'=>'\App\Http\Controllers\Admin\AjaxCotroller@separarProdutosSubmit']);
        Route::post('ajax/funcionarioEpis',['as'=>'admin.ajax.funcionario.epis', 'uses'=>'\App\Http\Controllers\Admin\AjaxCotroller@carregaEpis']);
        Route::post('ajax/verificaEmailDigitado',['as'=>'admin.ajax.funcionario.email.verifica', 'uses'=>'\App\Http\Controllers\Admin\AjaxCotroller@verificaEmailDigitado']);

        //PRODUTOS
        Route::get('/admin/produtos/listar','\App\Http\Controllers\Admin\ProductController@index')->name('admin.products');
        Route::get('/admin/produtos/listar/relatorio','\App\Http\Controllers\Admin\ProductController@relatorio')->name('admin.products.relatorio');
        Route::get('/admin/produtos/lixo','\App\Http\Controllers\Admin\ProductController@trash')->name('admin.products.trash');
        Route::get('/admin/produtos/form','\App\Http\Controllers\Admin\ProductController@create')->name('admin.products.form.create');
        Route::get('/admin/produtos/listar/form/{product}','\App\Http\Controllers\Admin\ProductController@edit')->name('admin.products.form.edit');
        Route::post('/admin/produtos/create','\App\Http\Controllers\Admin\ProductController@store')->name('admin.products.action.create');
        Route::post('/admin/produtos/update','\App\Http\Controllers\Admin\ProductController@update')->name('admin.products.action.update');
        Route::get('/admin/produtos/recycle/{product}','\App\Http\Controllers\Admin\ProductController@recycle')->name('admin.products.recycle');
        Route::get('/admin/produtos/destroy/{product}','\App\Http\Controllers\Admin\ProductController@destroy')->name('admin.products.destroy');

        //FUNCIONARIOS
        Route::get('/admin/funcionarios/listar','\App\Http\Controllers\Admin\EmployeeController@index')->name('admin.employees');
        Route::get('/admin/funcionarios/lixo','\App\Http\Controllers\Admin\EmployeeController@trash')->name('admin.employees.trash');
        Route::get('/admin/funcionarios/form','\App\Http\Controllers\Admin\EmployeeController@create')->name('admin.employees.form.create');
        Route::get('/admin/funcionarios/form/{employee}','\App\Http\Controllers\Admin\EmployeeController@edit')->name('admin.employees.form.edit');
        Route::post('/admin/funcionarios/create','\App\Http\Controllers\Admin\EmployeeController@store')->name('admin.employees.action.create');
        Route::post('/admin/funcionarios/update','\App\Http\Controllers\Admin\EmployeeController@update')->name('admin.employees.action.update');
        Route::get('/admin/funcionarios/recycle/{employee}','\App\Http\Controllers\Admin\EmployeeController@recycle')->name('admin.employees.recycle');
        Route::get('/admin/funcionarios/destroy/{employee}','\App\Http\Controllers\Admin\EmployeeController@destroy')->name('admin.employees.destroy');
        Route::get('/admin/funcionarios/listar/permissoes/{employee}','\App\Http\Controllers\Admin\EmployeeController@permission')->name('admin.employees.permission');
        Route::post('/admin/funcionarios/permissoes/do','\App\Http\Controllers\Admin\EmployeeController@permissionApply')->name('admin.employees.permission.do');
        Route::post('/admin/funcionarios/action','\App\Http\Controllers\Admin\EmployeeController@action')->name('admin.employees.action');
        Route::get('/admin/funcionarios/listar/epis','\App\Http\Controllers\Admin\EmployeeController@epis')->name('admin.employees.epis');



        //CLIENTS
        Route::get('/admin/clientes/listar','\App\Http\Controllers\Admin\ClientController@index')->name('admin.clients');
        Route::get('/admin/clientes/lixo','\App\Http\Controllers\Admin\ClientController@trash')->name('admin.clients.trash');
        Route::get('/admin/clientes/form','\App\Http\Controllers\Admin\ClientController@create')->name('admin.clients.form.create');
        Route::get('/admin/clientes/listar/form/{client}','\App\Http\Controllers\Admin\ClientController@edit')->name('admin.clients.form.edit');
        Route::get('/admin/clientes/listar/patrimony/{client}','\App\Http\Controllers\Admin\ClientController@patrimonyList')->name('admin.clients.patrimony.list');
        Route::post('/admin/clientes/patrimony/add','\App\Http\Controllers\Admin\ClientController@patrimonyAdd')->name('admin.clients.patrimony.add');
        Route::post('/admin/clientes/create','\App\Http\Controllers\Admin\ClientController@store')->name('admin.clients.action.create');
        Route::post('/admin/clientes/update','\App\Http\Controllers\Admin\ClientController@update')->name('admin.clients.action.update');
        Route::get('/admin/clientes/recycle/{client}','\App\Http\Controllers\Admin\ClientController@recycle')->name('admin.clients.recycle');
        Route::get('/admin/clientes/destroy/{client}','\App\Http\Controllers\Admin\ClientController@destroy')->name('admin.clients.destroy');

        //PROVIDERS
        Route::get('/admin/fornecedores/listar','\App\Http\Controllers\Admin\ProviderController@index')->name('admin.providers');
        Route::get('/admin/fornecedores/lixo','\App\Http\Controllers\Admin\ProviderController@trash')->name('admin.providers.trash');
        Route::get('/admin/fornecedores/form','\App\Http\Controllers\Admin\ProviderController@create')->name('admin.providers.form.create');
        Route::get('/admin/fornecedores/listar/form/{provider}','\App\Http\Controllers\Admin\ProviderController@edit')->name('admin.providers.form.edit');
        Route::post('/admin/fornecedores/create','\App\Http\Controllers\Admin\ProviderController@store')->name('admin.providers.action.create');
        Route::post('/admin/fornecedores/update','\App\Http\Controllers\Admin\ProviderController@update')->name('admin.providers.action.update');
        Route::get('/admin/fornecedores/recycle/{provider}','\App\Http\Controllers\Admin\ProviderController@recycle')->name('admin.providers.recycle');
        Route::get('/admin/fornecedores/destroy/{provider}','\App\Http\Controllers\Admin\ProviderController@destroy')->name('admin.providers.destroy');

        //PURCHASES
        Route::get('/admin/compras/listar','\App\Http\Controllers\Admin\PurchaseController@index')->name('admin.purchases');
        //Route::get('/admin/compras/lixo','\App\Http\Controllers\Admin\PurchaseController@trash')->name('admin.purchases.trash');
        Route::get('/admin/compras/form','\App\Http\Controllers\Admin\PurchaseController@create')->name('admin.purchases.form.create');
        Route::post('/admin/compras/create','\App\Http\Controllers\Admin\PurchaseController@store')->name('admin.purchases.action.create');

        //OUTPUTS
        Route::get('/admin/pedidos/listar','\App\Http\Controllers\Admin\OutputController@index')->name('admin.outputs');
        Route::get('/admin/pedidos/listar/relatorio','\App\Http\Controllers\Admin\OutputController@index')->name('admin.outputs.relatorio');
        Route::get('/admin/pedidos/listar/ordem','\App\Http\Controllers\Admin\OutputController@ordem')->name('admin.outputs.ordem');
        Route::get('/admin/pedidos/listar/relatorio','\App\Http\Controllers\Admin\OutputController@relatorio')->name('admin.outputs.relatorio');
        Route::get('/admin/pedidos/solicitados','\App\Http\Controllers\Admin\OutputController@solicitados')->name('admin.outputs.request');
        Route::get('/admin/pedidos/separados','\App\Http\Controllers\Admin\OutputController@separados')->name('admin.outputs.separated');
        Route::get('/admin/pedidos/rota','\App\Http\Controllers\Admin\OutputController@rota')->name('admin.outputs.route');
        Route::get('/admin/pedidos/entregues','\App\Http\Controllers\Admin\OutputController@entregues')->name('admin.outputs.delivered');
        Route::get('/admin/pedidos/lixo','\App\Http\Controllers\Admin\OutputController@trash')->name('admin.outputs.trash');
        Route::get('/admin/pedidos/form','\App\Http\Controllers\Admin\OutputController@create')->name('admin.outputs.form.create');
        Route::post('/admin/pedidos/create','\App\Http\Controllers\Admin\OutputController@store')->name('admin.outputs.action.create');
        Route::post('/admin/pedidos/action','\App\Http\Controllers\Admin\OutputController@action')->name('admin.outputs.action');
        Route::get('/admin/pedidos/destroy/{output}','\App\Http\Controllers\Admin\OutputController@destroy')->name('admin.outputs.destroy');
        Route::get('/admin/pedidos/recycle/{output}','\App\Http\Controllers\Admin\OutputController@recycle')->name('admin.outputs.recycle');

        //Route::get('/admin/compras/recycle/{id}','\App\Http\Controllers\Admin\PurchaseController@recycle')->name('admin.purchases.recycle');
        //Route::get('/admin/compras/destroy/{data}','\App\Http\Controllers\Admin\PurchaseController@destroy')->name('admin.purchases.destroy');
});
