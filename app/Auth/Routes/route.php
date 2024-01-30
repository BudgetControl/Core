<?php

use App\Auth\Controllers\AuthLoginController;
use App\Auth\Controllers\AuthRegisterController;
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

Route::post('/register',function(Request $request) {
    $auth = new AuthRegisterController();
    return $auth->register($request);
});

Route::get('/confirm/{token}',function(string $token) {
    $auth = new AuthRegisterController();
    return $auth->confirm($token);
});

Route::post('/authenticate',function(Request $request) {
    $auth = new AuthLoginController();
    return $auth->login($request);
});


// Route::post('/recovery',function(Request $request) {
//     $auth = new AuthController();
//     return $auth->recovery($request);
// });

// Route::put('/recovery/{token}',function(Request $request, string $token) {
//     $auth = new AuthController();
//     return $auth->reset($request, $token);
// });

// Route::get('/logout',function() {
//     $auth = new AuthController();
//     return $auth->logout();
// });