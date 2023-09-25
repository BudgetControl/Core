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

Route::post('/authenticate',function(Request $request) {
    $auth = new AuthController();
    return $auth->authenticate($request);
});

Route::get('/check',function() {
    $auth = new AuthController();
    return $auth->check();
})->middleware('auth.jwt');

Route::post('/login',function(Request $request) {
    $auth = new AuthController();
    return $auth->login($request);
});

Route::post('/register',function(Request $request) {
    $auth = new AuthController();
    return $auth->register($request);
});

Route::post('/verify-email',function(Request $request) {
    $auth = new AuthController();
    return $auth->sendVerifyEmail($request);
});

Route::get('/confirm/{token}',function(string $token) {
    $auth = new AuthController();
    return $auth->confirm($token);
});

Route::post('/recovery',function(Request $request) {
    $auth = new AuthController();
    return $auth->recovery($request);
});

Route::put('/recovery/{token}',function(Request $request, string $token) {
    $auth = new AuthController();
    return $auth->reset($request, $token);
});

Route::get('/logout',function() {
    $auth = new AuthController();
    return $auth->logout();
});

Route::get('/profile',function(Request $request) {
    $auth = new ProfileController();
    return $auth->index($request);
});

Route::delete('/delete',function(Request $request) {
    $auth = new ProfileController();
    return $auth->delete($request);
});
