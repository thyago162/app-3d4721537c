<?php

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

Route::group(['namespace' => 'Api'], function () {
    Route::resource('products', 'Product\ProductController');
    Route::resource('stock', 'Stock\StockController')->only('update');
    Route::resource('stock-balance', 'Historic\HistoricController')->only('index');
});