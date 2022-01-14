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
});
