<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DebtController;

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

Route::get('/generate-debts', [DebtController::class, 'generateFakeDebts']);

// Route::controller(DebtController::class)->group(function () {
//     Route::get('/generate-debts', 'generateFakeDebts');
// });
