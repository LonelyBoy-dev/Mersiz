<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::middleware('auth:sanctum')->post('/CheckUser', function (Request $request){
    return response()->json([
        'info' => $request->user()
    ], 201);
});

Route::get('/getSliders', 'Front\ApiController@getSliders');
Route::get('/getBanners', 'Front\ApiController@getBanners');
Route::get('/getBrands', 'Front\ApiController@getBrands');
Route::get('/getCategory', 'Front\ApiController@getCategory');
Route::get('/getImageCategory', 'Front\ApiController@getCategoryImage');
Route::get('/getCategoryProduct', 'Front\ApiController@getCategoryProduct');
Route::get('/getProducts/{categoryId}', 'Front\ApiController@getProducts');
Route::get('/getProduct/{id}', 'Front\ApiController@getProduct');
Route::get('/getPostsIndex', 'Front\ApiController@getPostsIndex');
Route::get('/getDayBasketProduct', 'Front\ApiController@getDayBasketProduct');
Route::get('/getDiscountProduct', 'Front\ApiController@getDiscountProduct');
Route::get('/getViewProducts/{id}', 'Front\ApiController@getViewProducts');
Route::get('/getGalleryProducts/{id}', 'Front\ApiController@getGalleryProducts');
Route::get('/getNewProducts/{id}', 'Front\ApiController@getNewProducts');
Route::get('/getLikeProducts/{id}', 'Front\ApiController@getLikeProducts');

Route::post('/registerMobile', 'Front\ApiController@registerMobile');
Route::post('/registerCode', 'Front\ApiController@registerCode');




///***************** Payment Cart  ******************/
Route::get('order-verify', 'Front\OrderController@verify');
Route::get('payment-verify', 'Front\PaymentController@verify');
Route::get('order-verify-before', 'Front\OrderController@verifybefore');
Route::get('payment-verify-before', 'Front\PaymentController@verifybefore');
///***************** Payment Cart  ******************/


///***************** Shopping Cart  ******************/
Route::post('/addcart', 'Front\ShoppingCartController@addcart')->middleware('auth:sanctum');
Route::post('/removecart', 'Front\ShoppingCartController@removecart')->middleware('auth:sanctum');
Route::post('/updatecart', 'Front\ShoppingCartController@updatecart');
Route::post('/CheckCart', 'Front\ShoppingCartController@CheckCart')->middleware('auth:sanctum');
Route::post('/getCart', 'Front\ShoppingCartController@getCart')->middleware('auth:sanctum');
///***************** Shopping Cart  ******************/


