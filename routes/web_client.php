<?php

use App\Http\Controllers\Web\AdminClient\DashboardClientController;
use App\Http\Controllers\Web\AdminClient\StockInController;
use App\Http\Controllers\Web\AdminClient\StockOutController;
use Illuminate\Support\Facades\Route;

Route::middleware(['client'])->group(function () {
    Route::get('/client-dashboard',                   [DashboardClientController::class, 'index'])->name('client.dashboard');

    Route::get('/client-stockin',                   [StockInController::class, 'index'])->name('client.stockin.index');
    Route::post('/client-stockin',                   [StockInController::class, 'store'])->name('client.stockin');
    Route::any('/client-stockin/{id}/destroy',      [StockInController::class, 'destroy'])->name('client.stockin.destroy');
    
    Route::get('/client-stockout',                   [StockOutController::class, 'index'])->name('client.stockout.index');
    Route::any('/client-stockout/{id}/destroy',      [StockOutController::class, 'destroy'])->name('client.stockout.destroy');
    Route::post('/client-stockout',                  [StockOutController::class, 'store'])->name('client.stockout');
});
