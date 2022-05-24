<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TablesController;
use App\Http\Controllers\Api\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api'
], function () {
    Route::get('/tenants', [TenantController::class, 'index']);
    Route::get('/tenants/{uuid}', [TenantController::class, 'show']);

    Route::get('/categories', [CategoryController::class, 'categories']);
    Route::get('/categories/{identify}',   [CategoryController::class, 'show']);

    Route::get('/tables', [TablesController::class, 'tablesByTenant']);
    Route::get('/tables/{identify}',   [TablesController::class, 'show']);

    Route::get('/products/{identify}', [ProductController::class, 'show']);
    Route::get('/products', [ProductController::class, 'productsByTenant']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
