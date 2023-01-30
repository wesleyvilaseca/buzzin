<?php

use App\Http\Controllers\Web\AdminClient\DashboardClientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['client'])->group(function () {
    Route::get('/client-dashboard',                   [DashboardClientController::class, 'index'])->name('client.dashboard');
});
