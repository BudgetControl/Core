<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/get', "App\Budget\Controllers\BudgetController@index");
Route::get('/get/{id}', "App\Budget\Controllers\BudgetController@show");
Route::post('/create', 'App\Budget\Controllers\BudgetController@create');
Route::put('/update/{id}', 'App\Budget\Controllers\BudgetController@update');
Route::delete('/', 'App\Budget\Controllers\BudgetController@delete');
Route::get('/stats', 'App\Budget\Controllers\BudgetController@stats');
Route::get('/stats/{id}', 'App\Budget\Controllers\BudgetController@stats');
Route::get('/expired/{id}', 'App\Budget\Controllers\BudgetController@expired');



