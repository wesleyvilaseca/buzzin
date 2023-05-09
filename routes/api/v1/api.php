<?php

use App\Http\Controllers\Api\Auth\AuthClientController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TablesController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\Auth\OrderController;
use App\Http\Controllers\Api\Auth\PaymentIntegration\MercadoPagoController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [RegisterController::class, 'store']);
Route::post('/auth/token', [AuthClientController::class, 'auth']);

Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/auth/me', [AuthClientController::class, 'me']);
    Route::post('/auth/logout', [AuthClientController::class, 'logout']);

    Route::post('/auth/v1/orders/{identifyOrder}/evaluations', [EvaluationController::class, 'store']);

    Route::get('/auth/v1/my-orders',    [OrderController::class, 'myOrders']);
    Route::post('/auth/v1/orders',      [OrderController::class, 'store']);
    
    /**
     * integration payment routes
     */
    Route::post('/auth/v1/mp-order',     [MercadoPagoController::class, 'store']);
});

Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api'
], function () {
    Route::get('/tenants', [TenantController::class, 'index']);
    Route::get('/tenants/{uuid}', [TenantController::class, 'show']);
    Route::get('/tenants-by-flag/{flag}', [TenantController::class, 'showByFlag']);

    Route::get('/categories', [CategoryController::class, 'categories']);
    Route::get('/categories/{identify}',   [CategoryController::class, 'show']);

    Route::get('/tables', [TablesController::class, 'tablesByTenant']);
    Route::get('/tables/{identify}',   [TablesController::class, 'show']);

    Route::get('/products/{identify}', [ProductController::class, 'show']);
    Route::get('/products', [ProductController::class, 'productsByTenant']);

    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{identify}', [OrderController::class, 'show']);
});
