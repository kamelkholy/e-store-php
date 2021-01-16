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

Route::get('/', function () {
    return view('dashboard');
});
Route::get('/admin', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/store', ['App\Http\Controllers\StoreController', 'index']);
Route::get('/store-categories', ['App\Http\Controllers\CategoriesController', 'getForStore']);

Route::resource('brands', 'App\Http\Controllers\BrandsController');
Route::resource('tags', 'App\Http\Controllers\TagsController');
Route::resource('products', 'App\Http\Controllers\ProductsController');
Route::resource('categories', 'App\Http\Controllers\CategoriesController');
Route::resource('types', 'App\Http\Controllers\TypeController');