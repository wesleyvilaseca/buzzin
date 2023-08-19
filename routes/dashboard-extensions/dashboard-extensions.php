<?php

use App\Http\Controllers\Web\Admin\DashboardExtension\WhatsappNewOrderNotifyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin-dashboard-extension')->group(function () {
        Route::get('/whatsapp-order-notify/{id}',       [WhatsappNewOrderNotifyController::class, 'index'])->name('admin.extension_dashboard.new_order_notify');
        Route::post('/whatsapp-order-notify/{id}',       [WhatsappNewOrderNotifyController::class, 'store'])->name('admin.extension_dashboard.new_order_notify.store');         
    });
});