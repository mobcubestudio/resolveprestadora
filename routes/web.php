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

    Route::get('/admin/produtos','\App\Http\Controllers\Admin\ProductController@index')->name('admin.products');
    //Route::get('/admin/produtos/{id}','\App\Http\Controllers\Admin\ProductController@show');
    Route::get('/admin/produtos/form','\App\Http\Controllers\Admin\ProductController@create')->name('admin.products.form.create');
    Route::get('/admin/produtos/form/{product}','\App\Http\Controllers\Admin\ProductController@edit')->name('admin.products.form.edit');
    Route::post('/admin/produtos/create','\App\Http\Controllers\Admin\ProductController@form')->name('admin.products.form.action');
});
