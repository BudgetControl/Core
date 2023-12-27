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


Route::get('/', "App\BudgetManager\Controllers\BudgetController@index");
Route::post('/', 'App\BudgetManager\Controllers\BudgetController@show');
Route::post('/', 'App\BudgetManager\Controllers\BudgetController@create');
Route::put('/', 'App\BudgetManager\Controllers\BudgetController@update');
Route::delete('/', 'App\BudgetManager\Controllers\BudgetController@delete');
Route::get('/stats', 'App\BudgetManager\Controllers\BudgetController@stats');
Route::get('/stats/{id}', 'App\BudgetManager\Controllers\BudgetController@stats');



