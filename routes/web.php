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



Auth::routes();

Route::get('/test', 'TelegramBotController@index');

Route::post('6348671637:AAEminvDP9BKM0Xh7uAOAUKKHBLjegVwH2w/handleWebhook', 'TelegramBotController@handle');

Route::get('/setWebhook', 'TelegramBotController@setWebhook');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/', 'ItemsController@index')->name('item.index');

    Route::post('/', 'ItemsController@store')->name('item.store');

    Route::patch('/{item}', 'ItemsController@update')->name('item.update');

    Route::delete('/{item}', 'ItemsController@destroy')->name('item.delete');

    Route::get('/profile', 'UsersController@index')->name('user.index');
 
    Route::post('/profile', 'UsersController@store')->name('user.store');

    Route::post('/add-token', 'TelegramBotController@tryAddToken');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
