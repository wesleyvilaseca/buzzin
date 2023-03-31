<?php

use App\Http\Controllers\Api\Auth\OrderTenantController;
use App\Http\Controllers\Web\Admin\SubscriptionController;
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
    Route::get('/plans', [SubscriptionController::class, 'getPlans'])->middleware(['auth']);
    Route::post('/paycard', [SubscriptionController::class, 'payCard'])->middleware(['auth']);

});