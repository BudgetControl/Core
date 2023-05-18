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

Route::get('/import/download-csv-template',[ \App\BudgetTracker\Http\Controllers\ImportController::class, 'viewCSV']);
Route::get('/entries/export', '\App\BudgetTracker\Http\Controllers\ImportController@export');
