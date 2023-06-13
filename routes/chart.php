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

Route::get('line/incoming/year', '\App\Charts\Controllers\LineChartController@incomingYear')->middleware('auth.jwt');
Route::get('line/incoming/month', '\App\Charts\Controllers\LineChartController@incomingMonth')->middleware('auth.jwt');
Route::get('line/incoming/day', '\App\Charts\Controllers\LineChartController@incomingDay')->middleware('auth.jwt');
Route::get('line/incoming/category', '\App\Charts\Controllers\LineChartController@incomingByCategory')->middleware('auth.jwt');
Route::get('line/incoming/label', '\App\Charts\Controllers\LineChartController@incomingByLabel')->middleware('auth.jwt');

Route::get('line/expenses/year', '\App\Charts\Controllers\LineChartController@expensesYear')->middleware('auth.jwt');
Route::get('line/expenses/month', '\App\Charts\Controllers\LineChartController@expensesMonth')->middleware('auth.jwt');
Route::get('line/expenses/day', '\App\Charts\Controllers\LineChartController@expensesDay')->middleware('auth.jwt');
Route::get('line/expenses/category', '\App\Charts\Controllers\LineChartController@expensesByCategory')->middleware('auth.jwt');
Route::get('line/expenses/label', '\App\Charts\Controllers\LineChartController@expensesByLabel')->middleware('auth.jwt');

Route::get('line/incoming-expenses', '\App\Charts\Controllers\LineChartController@incomingExpenses')->middleware('auth.jwt');

Route::get('bar/incoming/year', '\App\Charts\Controllers\BarChartController@incomingYear')->middleware('auth.jwt');
Route::get('bar/incoming/month', '\App\Charts\Controllers\BarChartController@incomingMonth')->middleware('auth.jwt');
Route::get('bar/incoming/day', '\App\Charts\Controllers\BarChartController@incomingDay')->middleware('auth.jwt');
Route::get('bar/incoming/category', '\App\Charts\Controllers\BarChartController@incomingByCategory')->middleware('auth.jwt');
Route::get('bar/incoming/label', '\App\Charts\Controllers\BarChartController@incomingByLabel')->middleware('auth.jwt');

Route::get('bar/expenses/year', '\App\Charts\Controllers\BarChartController@expensesYear')->middleware('auth.jwt');
Route::get('bar/expenses/month', '\App\Charts\Controllers\BarChartController@expensesMonth')->middleware('auth.jwt');
Route::get('bar/expenses/day', '\App\Charts\Controllers\BarChartController@expensesDay')->middleware('auth.jwt');
Route::get('bar/expenses/category', '\App\Charts\Controllers\BarChartController@expensesByCategory')->middleware('auth.jwt');
Route::get('bar/expenses/label', '\App\Charts\Controllers\BarChartController@expensesByLabel')->middleware('auth.jwt');

Route::get('bar/incoming-expenses', '\App\Charts\Controllers\BarChartController@incomingExpenses')->middleware('auth.jwt');




