<?php

use Illuminate\Support\Facades\Route;
use App\User\Controllers\AuthController;
use Illuminate\Http\Request;

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


Route::get('all', "Search\Controllers\SearchController@index");
Route::post('filter', 'Search\Controllers\SearchController@show');
