<?php

use Illuminate\Http\Request;
use App\Mailer\Services\MailService;
use App\Mailer\Services\Registration;
use Illuminate\Support\Facades\Route;
use App\BudgetTracker\Models\Currency;
use App\User\Controllers\AuthController;
use App\Exchange\Services\ExchangeService;

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

Route::apiResource('incoming', \App\BudgetTracker\Http\Controllers\IncomingController::class)->middleware('auth.jwt');
Route::apiResource('expenses', \App\BudgetTracker\Http\Controllers\ExpensesController::class)->middleware('auth.jwt');
Route::apiResource('investments', \App\BudgetTracker\Http\Controllers\InvestmentsController::class)->middleware('auth.jwt');
Route::apiResource('debit', \App\BudgetTracker\Http\Controllers\DebitController::class)->middleware('auth.jwt');
Route::apiResource('transfer', \App\BudgetTracker\Http\Controllers\TransferController::class)->middleware('auth.jwt');
Route::apiResource('planning-recursively', \App\BudgetTracker\Http\Controllers\PlanningRecursivelyController::class)->middleware('auth.jwt');
Route::apiResource('payee', \App\BudgetTracker\Http\Controllers\PayeeController::class)->middleware('auth.jwt');
Route::apiResource('entry', \App\BudgetTracker\Http\Controllers\EntryController::class)->middleware('auth.jwt');

Route::apiResource('categories', \App\BudgetTracker\Http\Controllers\CategoryController::class);
Route::apiResource('accounts', \App\BudgetTracker\Http\Controllers\AccountController::class)->middleware('auth.jwt');
Route::apiResource('labels', \App\BudgetTracker\Http\Controllers\LabelController::class);
Route::apiResource('currencies', \App\BudgetTracker\Http\Controllers\CurrencyController::class);
Route::apiResource('model', \App\BudgetTracker\Http\Controllers\ModelController::class);
Route::apiResource('paymentstype', \App\BudgetTracker\Http\Controllers\PaymentTypeController::class);

// RESTORE API
Route::get('account-restore/{id}', "\App\BudgetTracker\Http\Controllers\AccountController@restore")->middleware('auth.jwt');

// CUSTOM API

Route::put('sorting-account/{id}', function(Request $request, int $id) {
    $controller = new \App\BudgetTracker\Http\Controllers\AccountController();
    return $controller->sorting($id,$request->sorting);

})->middleware('auth.jwt');


Route::get('entry/account/{id}', function (string $id) {
    return \App\BudgetTracker\Http\Controllers\EntryController::getEntriesFromAccount((int) $id);
})->middleware('auth.jwt');

Route::post('entries/import', '\App\BudgetTracker\Http\Controllers\ImportController@import')->middleware('auth.jwt');

/** make accounts api */
Route::put('accounts/update-value', '\App\BudgetTracker\Http\Controllers\ImportController@save')->middleware('auth.jwt');

// #### USERS SETTINGS
Route::post("/user/currency", 'App\User\Controllers\UserSettingController@setDefaultCurrency')->middleware('auth.jwt');
Route::get("/user/settings", 'App\User\Controllers\UserSettingController@index')->middleware('auth.jwt');