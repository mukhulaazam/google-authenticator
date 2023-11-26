<?php

use App\Http\Controllers\AuthenticatorController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('enable-2fa',[AuthenticatorController::class, 'enable2fa'])->name('2fa.enable');
Route::post('enable-2fa',[AuthenticatorController::class, 'storeEnable2fa'])->name('2fa.enable');
Route::post('2fa/validate',[AuthenticatorController::class, 'verifySecretKey'])->name('2fa.validate');

