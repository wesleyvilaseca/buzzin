<?php

use App\Http\Controllers\Api\Auth\OrderTenantController;
use App\Http\Controllers\Web\Admin\SubscriptionController;
use App\Http\Controllers\Web\Admin\TransactionNotificationController;
use App\Http\Controllers\Web\Admin\PaymentIntegration\MercadoPagoIntegrationController;
use App\Http\Controllers\Web\Admin\TenantTicketsController;
use App\Http\Controllers\Web\Admin\TicketsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api'
], function () {
    Route::get('/my-orders', [OrderTenantController::class, 'index'])->middleware(['auth']);
    Route::patch('/my-orders', [OrderTenantController::class, 'update'])->middleware(['auth']);

    /**
     * tickets routes
     */
    Route::get('/my-tickets',   [TenantTicketsController::class, 'getAll'])->middleware(['auth']);
    Route::post('/new-ticket',  [TenantTicketsController::class, 'store'])->middleware(['auth']);

    Route::get('/{id}/ticket',  [TenantTicketsController::class, 'getTicket'])->middleware(['auth']);
    Route::post('/{id}/ticket', [TenantTicketsController::class, 'sendMessage'])->middleware(['auth']);
    Route::get('/tickets-by-tenant', [TenantTicketsController::class, 'getAllByTenant'])->middleware(['auth']);
    Route::put('/{id}/ticket', [TenantTicketsController::class, 'closeTicket'])->middleware(['auth']);

    Route::get('/tickets',              [TicketsController::class, 'getAllSupport'])->middleware(['auth']);
    Route::get('/{id}/ticket-support',  [TicketsController::class, 'getTicket'])->middleware(['auth']);
    Route::get('/tickets-by-attendant', [TicketsController::class, 'getAllByattendant'])->middleware(['auth']);
    Route::post('/{id}/ticket-support', [TicketsController::class, 'sendMessage'])->middleware(['auth']);
    Route::put('/{id}/ticket-support', [TicketsController::class, 'closeTicket'])->middleware(['auth']);

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

