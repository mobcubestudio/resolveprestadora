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

Route::namespace('Admin')->group(function (){
    Route::get('/admin','\App\Http\Controllers\Admin\HomeController@index')->name('admin.home');

    //AJAX
    Route::post('ajax/produtos_comprados',['as'=>'admin.ajax.produtos_comprados', 'uses'=>'\App\Http\Controllers\Admin\AjaxCotroller@produtosComprados']);

    //PRODUTOS
    Route::get('/admin/produtos','\App\Http\Controllers\Admin\ProductController@index')->name('admin.products');
    Route::get('/admin/produtos/lixo','\App\Http\Controllers\Admin\ProductController@trash')->name('admin.products.trash');
    Route::get('/admin/produtos/form','\App\Http\Controllers\Admin\ProductController@create')->name('admin.products.form.create');
    Route::get('/admin/produtos/form/{product}','\App\Http\Controllers\Admin\ProductController@edit')->name('admin.products.form.edit');
    Route::post('/admin/produtos/create','\App\Http\Controllers\Admin\ProductController@store')->name('admin.products.action.create');
    Route::post('/admin/produtos/update','\App\Http\Controllers\Admin\ProductController@update')->name('admin.products.action.update');
    Route::get('/admin/produtos/recycle/{id}','\App\Http\Controllers\Admin\ProductController@recycle')->name('admin.products.recycle');
    Route::get('/admin/produtos/destroy/{product}','\App\Http\Controllers\Admin\ProductController@destroy')->name('admin.products.destroy');

    //FUNCIONARIOS
    Route::get('/admin/funcionarios','\App\Http\Controllers\Admin\EmployeeController@index')->name('admin.employees');
    Route::get('/admin/funcionarios/lixo','\App\Http\Controllers\Admin\EmployeeController@trash')->name('admin.employees.trash');
    Route::get('/admin/funcionarios/form','\App\Http\Controllers\Admin\EmployeeController@create')->name('admin.employees.form.create');
    Route::get('/admin/funcionarios/form/{employee}','\App\Http\Controllers\Admin\EmployeeController@edit')->name('admin.employees.form.edit');
    Route::post('/admin/funcionarios/create','\App\Http\Controllers\Admin\EmployeeController@store')->name('admin.employees.action.create');
    Route::post('/admin/funcionarios/update','\App\Http\Controllers\Admin\EmployeeController@update')->name('admin.employees.action.update');
    Route::get('/admin/funcionarios/recycle/{id}','\App\Http\Controllers\Admin\EmployeeController@recycle')->name('admin.employees.recycle');
    Route::get('/admin/funcionarios/destroy/{employee}','\App\Http\Controllers\Admin\EmployeeController@destroy')->name('admin.employees.destroy');


    //CLIENTS
    Route::get('/admin/clientes','\App\Http\Controllers\Admin\ClientController@index')->name('admin.clients');
    Route::get('/admin/clientes/lixo','\App\Http\Controllers\Admin\ClientController@trash')->name('admin.clients.trash');
    Route::get('/admin/clientes/form','\App\Http\Controllers\Admin\ClientController@create')->name('admin.clients.form.create');
    Route::get('/admin/clientes/form/{client}','\App\Http\Controllers\Admin\ClientController@edit')->name('admin.clients.form.edit');
    Route::post('/admin/clientes/create','\App\Http\Controllers\Admin\ClientController@store')->name('admin.clients.action.create');
    Route::post('/admin/clientes/update','\App\Http\Controllers\Admin\ClientController@update')->name('admin.clients.action.update');
    Route::get('/admin/clientes/recycle/{id}','\App\Http\Controllers\Admin\ClientController@recycle')->name('admin.clients.recycle');
    Route::get('/admin/clientes/destroy/{data}','\App\Http\Controllers\Admin\ClientController@destroy')->name('admin.clients.destroy');

    //PROVIDERS
    Route::get('/admin/fornecedores','\App\Http\Controllers\Admin\ProviderController@index')->name('admin.providers');
    Route::get('/admin/fornecedores/lixo','\App\Http\Controllers\Admin\ProviderController@trash')->name('admin.providers.trash');
    Route::get('/admin/fornecedores/form','\App\Http\Controllers\Admin\ProviderController@create')->name('admin.providers.form.create');
    Route::get('/admin/fornecedores/form/{provider}','\App\Http\Controllers\Admin\ProviderController@edit')->name('admin.providers.form.edit');
    Route::post('/admin/fornecedores/create','\App\Http\Controllers\Admin\ProviderController@store')->name('admin.providers.action.create');
    Route::post('/admin/fornecedores/update','\App\Http\Controllers\Admin\ProviderController@update')->name('admin.providers.action.update');
    Route::get('/admin/fornecedores/recycle/{id}','\App\Http\Controllers\Admin\ProviderController@recycle')->name('admin.providers.recycle');
    Route::get('/admin/fornecedores/destroy/{data}','\App\Http\Controllers\Admin\ProviderController@destroy')->name('admin.providers.destroy');

    //PURCHASES
    Route::get('/admin/compras','\App\Http\Controllers\Admin\PurchaseController@index')->name('admin.purchases');
    //Route::get('/admin/compras/lixo','\App\Http\Controllers\Admin\PurchaseController@trash')->name('admin.purchases.trash');
    Route::get('/admin/compras/form','\App\Http\Controllers\Admin\PurchaseController@create')->name('admin.purchases.form.create');
    Route::post('/admin/compras/create','\App\Http\Controllers\Admin\PurchaseController@store')->name('admin.purchases.action.create');

    //Route::get('/admin/compras/recycle/{id}','\App\Http\Controllers\Admin\PurchaseController@recycle')->name('admin.purchases.recycle');
    //Route::get('/admin/compras/destroy/{data}','\App\Http\Controllers\Admin\PurchaseController@destroy')->name('admin.purchases.destroy');
});
