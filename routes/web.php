<?php

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */
/*
 * Route::get('/', function () {
 * return view('home', 'PagesController@home');
 * });
 */

Route::post('register/check_key', 'Auth\RegisterController@check_key');
Auth::routes();

//Route::get('/', 'PagesController@index')->name('home');
Route::get('/', 'PagesController@index');


Route::get ( '/master/', 'PagesController@master' );

Route::get ('/masters/products/management', 'PagesController@productsmanagement')->name('products.management');


//暗黙
Route::resource('masters/brands', 'Masters\BrandsController');
Route::post('masters/brands/batch', 'Masters\BrandsController@batch');

Route::resource('masters/suppliers', 'Masters\SuppliersController');
Route::post('masters/suppliers/batch', 'Masters\SuppliersController@batch');

Route::resource('masters/categories', 'Masters\CategoriesController');
Route::post('masters/categories/batch', 'Masters\CategoriesController@batch');

Route::resource('masters/products', 'Masters\ProductsController');
Route::post ('masters/products/search', 'Masters\ProductsController@search')->name('products.search');//ajaxの場合は第一引数の末尾に{keyword?}を付ける
//Route::get ('masters/products/management', 'Masters\ProductsController@management')->name('products.management');
Route::post('masters/products/batch', 'Masters\ProductsController@batch');
Route::post('masters/products/batch_update', 'Masters\ProductsController@batch_update');
Route::post('masters/products/batchfile_download', 'Masters\ProductsController@batchfile_download');
Route::post('masters/products/smilecomplete', 'Masters\ProductsController@smilecomplete');



/*
Route::get('masters/suppliers', function(){
	//ユーザー情報取得
	$users = App\User::all();

	return 

});
*/

//index
//Route::get('/masters/brands', 'Masters\BrandsController@index' )->middleware('auth');


//edit
//Route::get('/master/brand/edit/{id}', 'Masters\BrandsController@getEdit')->middleware('auth');
//Route::put('/brands/{brand}', 'Masters\BrandsController@update')->middleware('auth');


//create
//Route::get('/master/brand/create', 'Masters\BrandsController@getCreate' )->middleware('auth');
//Route::post('/master/brand/create', 'Masters\BrandsController@postCreate' )->middleware('auth');
/////Route::get('masters/brands/create', 'Masters\BrandsController@create')->middleware('auth');
/////Route::post('masters/brands', 'Masters\BrandsController@store')->middleware('auth');
//show
//Route::get('/master/brand/show/', 'Masters\BrandsController@getShow');

/*
Route::get('/', 'ArticlesController@getIndex');
Route::controller('articles', 'ArticlesController');
*/