<?php

use App\Product;
use App\User;

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

Route::get('/', function() {
    return view('invoices.invoice');
});
Route::get('/inv', 'TransactionController@downloadInvoice');

Route::get('/elasticquentproduct', function () {
    // Product::createIndex($shards = null, $replicas = null);
    Product::putMapping($ignoreConflicts = true);
    Product::addAllToIndex();

    // Product::rebuildMapping();
});

Route::get('/elasticquentuser', function() {
    // dd(User::typeExists());
    User::putMapping($ignoreConflicts = true);
    User::addAllToIndex();
    echo "Done Mapping to Elasticsearch";
});

// Route::get('/', 'HOController@convertHODBToUsefulDB');
// Route::get('/', 'HOController@saveRajaOngkirData');