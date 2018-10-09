<?php

use App\Product;

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
    return view('welcome');
});

Route::get('/elasticquentproduct', function () {
    // Product::createIndex($shards = null, $replicas = null);
    Product::putMapping($ignoreConflicts = true);
    Product::addAllToIndex();
    echo "Done Mapping to Elasticsearch";
    // Product::rebuildMapping();
});

// Route::get('/', 'HOController@convertHODBToUsefulDB');
// Route::get('/', 'HOController@saveRajaOngkirData');