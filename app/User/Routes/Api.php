<?php

use App\User\Controllers\AuthController;
use App\User\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/profile',function(Request $request) {
    $auth = new ProfileController();
    return $auth->index($request);
});

Route::delete('/delete',function(Request $request) {
    $auth = new ProfileController();
    return $auth->delete($request);
});

Route::delete('/data/delete',function(Request $request) {
    $auth = new ProfileController();
    return $auth->delete($request);
});
