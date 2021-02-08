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
    return redirect()->route('store');
});


Route::get('/store', ['App\Http\Controllers\StoreController', 'index'])->name('store');
Route::get('/store/cart', ['App\Http\Controllers\StoreController', 'cart'])->name('store.cart');
Route::post('/store/checkout', ['App\Http\Controllers\StoreController', 'checkout'])->name('store.checkout');
Route::post('/store/place-order', ['App\Http\Controllers\StoreController', 'placeOrder'])->name('store.placeOrder');
Route::get('/store/compare', ['App\Http\Controllers\StoreController', 'compare'])->name('store.compare');
Route::post('/store/compare', ['App\Http\Controllers\StoreController', 'compareProducts'])->name('store.compareProducts');
Route::post('/store/refresh-cart', ['App\Http\Controllers\StoreController', 'refreshCart'])->name('store.refreshCart');
Route::get('store/products', ['App\Http\Controllers\StoreController', 'products'])->name('store.products');
Route::get('store/products/{id}', ['App\Http\Controllers\StoreController', 'aproduct'])->name('store.aproduct');
Route::get('store/products-images/{id}', ['App\Http\Controllers\StoreController', 'showProductImage'])->name('store.product.image');
Route::get('store/cart-product/{id}', ['App\Http\Controllers\StoreController', 'getCartProduct'])->name('store.cart.product');
Route::get('store/products/category/{id}', ['App\Http\Controllers\StoreController', 'productsByCategory'])->name('store.products.category');
Route::get('/store-categories', ['App\Http\Controllers\CategoriesController', 'getForStore']);


Route::get('/admin', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/dashboard/login', ['App\Http\Controllers\LoginController', 'authenticate'])->name('dashboard.login');


Route::resource('users', 'App\Http\Controllers\UsersController')->middleware('auth');
Route::resource('customers', 'App\Http\Controllers\CustomersController')->middleware('auth');
Route::resource('brands', 'App\Http\Controllers\BrandsController')->middleware('auth');
Route::resource('featuredCategories', 'App\Http\Controllers\FeaturedCategoriesController')->middleware('auth');
Route::resource('sliders', 'App\Http\Controllers\SlidersController')->middleware('auth');
Route::resource('tags', 'App\Http\Controllers\TagsController')->middleware('auth');
Route::resource('orders', 'App\Http\Controllers\OrdersController')->middleware('auth');
Route::resource('products', 'App\Http\Controllers\ProductsController')->middleware('auth');
Route::resource('categories', 'App\Http\Controllers\CategoriesController')->middleware('auth');
Route::resource('types', 'App\Http\Controllers\TypeController')->middleware('auth');
Route::resource('cityShippings', 'App\Http\Controllers\CityShippingController')->middleware('auth');
Route::resource('storeSettings', 'App\Http\Controllers\StoreSettingController')->middleware('auth');

Route::post('/orders/{id}/change-status', ['App\Http\Controllers\OrdersController', 'changeStatus'])->middleware('auth')->name('orders.changeStatus');
Route::get('/featuredCategories/{id}/products', ['App\Http\Controllers\FeaturedCategoriesController', 'getProducts'])->middleware('auth')->name('featuredCategories.getProducts');
