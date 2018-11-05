<?php

use Illuminate\Http\Request;

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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization, auth');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'AuthController@register')->name('register');
Route::post('login', 'AuthController@login')->name('login');
Route::get('logout', 'AuthController@logout')->name('logout');
Route::get('admin', 'AuthController@getAdmins')->name('getAdmins');
Route::post('admin/invite', 'AuthController@inviteAdmin')->name('inviteAdmin');
Route::get('admin/verify/{token}', 'AuthController@activateAccount')->name('activateAccount'); //not asked lol, i'm improvise

Route::apiResource('products', 'ProductController');
Route::apiResource('categories', 'CategoryController');
Route::get('allcategories', 'CategoryController@allCategories');
Route::apiResource('promotions', 'PromoController');
Route::get('payment/download', 'CartController@export');
Route::apiResource('users', 'UserController');
Route::apiResource('populars', 'ProductTagController');
Route::get('checkUsername/{username}', 'AuthController@checkUsername');
Route::get('applyvoucher/{voucher}', 'VoucherController@checkVoucher');
Route::get('nestedCategory', 'CategoryController@getNested');
Route::get('similars', 'ProductController@getSimilarProducts');
Route::apiResource('images', 'ImageController');
Route::get('invoice/download', 'TransactionController@downloadInvoice');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('add-resi/{id}', 'TransactionController@addResi');
    Route::apiResource('admins', 'AdminController');
    Route::apiResource('vouchers', 'VoucherController');
    Route::post('me', 'AuthController@meFromToken')->name('me');
    Route::apiResource('favorites', 'FavoriteProductController');
    Route::apiResource('carts', 'CartController');
    Route::apiResource('reviews', 'ReviewController');
    Route::apiResource('discussions', 'DiscussionController');
    Route::apiResource('transactions', 'TransactionController');
    Route::post('header-transaction', 'TransactionController@addHeader');
    Route::get('orders', 'TransactionController@getOrders');
    Route::get('ongoing-orders', 'TransactionController@getOngoingTransactions');
    Route::get('finished-orders', 'TransactionController@getFinishedTransactions');
});
