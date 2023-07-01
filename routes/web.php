<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'ItemsController@index')->name('item.index');

Route::get('/{sorting}', 'ItemsController@show')->name('item.show');

Route::post('/', 'ItemsController@store')->name('item.store');

Route::patch('/{item}', 'ItemsController@update')->name('item.update');

Route::delete('/{item}', 'ItemsController@destroy')->name('item.delete');
