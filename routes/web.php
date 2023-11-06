<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

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


Route::get('/', [WebController::class, 'index']);
Route::get('/payment', [WebController::class, 'payment']);
Route::get('/payment_voucher', [WebController::class, 'payment_voucher']);
Route::get('/payment_test', [WebController::class, 'payment_test']);
Route::get('/success', [WebController::class, 'success']);
Route::get('/thankyou', [WebController::class, 'thankyou']);
Route::post('/payment', [WebController::class, 'payment_post']);
