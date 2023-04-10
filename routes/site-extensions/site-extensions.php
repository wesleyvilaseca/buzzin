<?php

use App\Http\Controllers\Web\Admin\SiteExtension\WhatsappExtensionsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin-site-extension')->group(function () {
        Route::get('/whatsapp/{id}',       [WhatsappExtensionsController::class, 'index'])->name('admin.extension_site.whatsapp');
        Route::post('/whatsapp/{id}',       [WhatsappExtensionsController::class, 'store'])->name('admin.extension_site.whatsapp.store');
    });
});