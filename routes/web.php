<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomAuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/wompi', [TransactionController::class,'show']);
Route::get('/save', [TransactionController::class,'save']);

Route::get('/', [CustomAuthController::class, 'dashboard']);
Route::get('login', [CustomAuthController::class, 'index']);
Route::post('custom-login', [CustomAuthController::class, 'Login'])->name('login'); 
Route::post('logout', [CustomAuthController::class, 'logout'])->name('logout');

Route::get('fetch/transaction', [CustomAuthController::class, 'fetch_transaction']);
Route::get('fetch/retiro', [CustomAuthController::class, 'fetch_retiro']);
Route::get('fetch/payed', [CustomAuthController::class, 'fetch_payed']);
Route::post('save/city', [CustomAuthController::class, 'SaveCity']); 
Route::post('edit/city/{id}', [CustomAuthController::class, 'EditCity']); 
Route::post('save/type', [CustomAuthController::class, 'SaveType']); 
Route::post('edit/type/{id}', [CustomAuthController::class, 'EditType']);
Route::get('save/payed/{id}', [CustomAuthController::class, 'SavePayed']); 





