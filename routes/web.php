<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/pay-index', [PaymentController::class, 'PayIndex']);
Route::post('/pay-index', [PaymentController::class, 'MakePayment'])->name('pay');
Route::get('/pay/callback', [PaymentController::class, 'PaymentCallback'])->name('pay.callback');