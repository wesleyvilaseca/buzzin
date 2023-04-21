<?php

use App\Http\Controllers\Web\Admin\PaymentIntegration\MercadoPagoIntegrationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin-payment-integration')->group(function () {
        Route::get('/mp/{id}',       [MercadoPagoIntegrationController::class, 'index'])->name('payment_integration.mercadopago');
        Route::post('/mp/{id}',      [MercadoPagoIntegrationController::class, 'store'])->name('payment_integration.mercadopago.store');
    });
});