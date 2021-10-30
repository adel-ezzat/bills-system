<?php

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

    Route::get('/', 'BillsController@add')->name('bill.items.add');
    Route::post('items-by-id', 'BillsController@getItemByid')->name('bill.items.id');
    Route::post('create', 'BillsController@create')->name('bill.items.create');
    Route::get('all', 'BillsController@showBillsList')->name('bill.items.view');
    Route::get('view/{id}/', 'BillsController@BillDetails')->name('bill.items.view.id');
