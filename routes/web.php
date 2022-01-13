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
    Route::get('/admin/produtos/lixo','\App\Http\Controllers\Admin\ProductController@trash')->name('admin.products.trash');
    //Route::get('/admin/produtos/{id}','\App\Http\Controllers\Admin\ProductController@show');
    Route::get('/admin/produtos/form','\App\Http\Controllers\Admin\ProductController@create')->name('admin.products.form.create');
    Route::get('/admin/produtos/form/{product}','\App\Http\Controllers\Admin\ProductController@edit')->name('admin.products.form.edit');
    Route::post('/admin/produtos/create','\App\Http\Controllers\Admin\ProductController@store')->name('admin.products.action.create');
    Route::post('/admin/produtos/update','\App\Http\Controllers\Admin\ProductController@update')->name('admin.products.action.update');
    Route::get('/admin/produtos/recycle/{id}','\App\Http\Controllers\Admin\ProductController@recycle')->name('admin.products.recycle');
    Route::get('/admin/produtos/destroy/{product}','\App\Http\Controllers\Admin\ProductController@destroy')->name('admin.products.destroy');

});
