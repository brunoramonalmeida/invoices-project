<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DebtController;
use App\Http\Controllers\InvoiceController;
use App\Models\Invoice;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('invoice/generate', [InvoiceController::class, 'generateInvoice']);

Route::post('invoice/generate-all', [InvoiceController::class, 'generateInvoices']);

Route::post('/process-debts', [DebtController::class, 'processDebts']);

Route::post('/hooks/payment', [InvoiceController::class, 'receivePayment']);

Route::get('/generate-debts', [DebtController::class, 'generateFakeDebts']);
