<?php

use App\Http\Controllers\AuthController;
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

Route::post('/authenticate',function(Request $request) {
    $auth = new AuthController();
    return $auth->authenticate($request);
});

Route::post('/login',function(Request $request) {
    $auth = new AuthController();
    return $auth->login($request);
});

Route::post('/register',function(Request $request) {
    $auth = new AuthController();
    return $auth->register($request);
});

Route::get('/logout',function() {
    $auth = new AuthController();
    return $auth->logout();
});


