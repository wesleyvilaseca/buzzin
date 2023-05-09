<?php

use App\Http\Controllers\Api\Auth\OrderTenantController;
use App\Http\Controllers\Web\Admin\SubscriptionController;
use App\Http\Controllers\Web\Admin\TransactionNotificationController;
use App\Http\Controllers\Web\Admin\PaymentIntegration\MercadoPagoIntegrationController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api'
], function () {
    Route::get('/my-orders', [OrderTenantController::class, 'index'])->middleware(['auth']);
    Route::patch('/my-orders', [OrderTenantController::class, 'update'])->middleware(['auth']);

    /**
     * admis-subscription
     */
    Route::get('/plans',        [SubscriptionController::class, 'getPlans'])->middleware(['auth']);
    Route::post('/paycard',     [SubscriptionController::class, 'payCard'])->middleware(['auth']);
    Route::post('/payslip',     [SubscriptionController::class, 'payslip'])->middleware(['auth']);
    Route::post('/pix',         [SubscriptionController::class, 'pix'])->middleware(['auth']);
    Route::post('/mp-notify',   [TransactionNotificationController::class, 'mpNotify']);

    /**
     * payment integration config
     */
    Route::prefix('admin-payment-integration')->group(function () {
        /**
         * mercado pago
         */
        Route::get('/mp/{id}',       [MercadoPagoIntegrationController::class, 'index'])->name('payment_integration.mercadopago')->middleware(['auth']);
        Route::post('/mp/{id}',      [MercadoPagoIntegrationController::class, 'store'])->name('payment_integration.mercadopago.store')->middleware(['auth']);
    });
});

