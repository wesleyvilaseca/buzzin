<?php

use App\Http\Controllers\Web\TenantSite\AccountRecoverLoginController;
use App\Http\Controllers\Web\TenantSite\CartController;
use App\Http\Controllers\Web\TenantSite\CategoryController as TenantSiteCategoryController;
use App\Http\Controllers\Web\TenantSite\CheckoutController;
use App\Http\Controllers\Web\TenantSite\ClientController;
use App\Http\Controllers\Web\TenantSite\LoginController as TenantSiteLoginController;
use App\Http\Controllers\Web\TenantSite\ProductController as TenantSiteProductController;
use App\Http\Controllers\Web\TenantSite\RegisterController as TenantSiteRegisterController;
use App\Http\Controllers\Web\TenantSite\TenantController as TenantSiteTenantController;
use App\Http\Controllers\Web\TenantSite\HomeController as ClientSiteHomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\TenantSite\ReCaptchaV3Controller;
use App\Supports\Helper\Utils;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

/**
 * site routes
 */

$domain = request()->getHttpHost();
$appDomain = str_replace(['http://', 'https://'], "", env('APP_URL'));
$url = explode('/', str_replace(['http://', 'https://'], "", Request::url()));


Utils::getSite($domain, isset($url[1]) ? $url[1] : null, false);
$isTenantSiteDomainOrSubDomain = Cache::get('tenant-site-' . $domain);
$isDefaultPrefixDomain =  Cache::get(isset($url[1]) ? 'tenant-site-' . $url[1] : null);

if ($isDefaultPrefixDomain || $isTenantSiteDomainOrSubDomain) {
    Route::group(['prefix' => $isDefaultPrefixDomain ? $url[1] : '' ], function(){
        Route::get('/site-em-manutencao',         [ClientSiteHomeController::class, 'inMaintence'])->name('tenant.maintence');
        Route::get('/recaptcha-validate',         [ReCaptchaV3Controller::class, 'validateV3']);

        Route::middleware(['check.site.client'])->group(function () {
            Route::any('/',         [ClientSiteHomeController::class, 'index'])->name('app.home');
            Route::prefix('app')->group(function () {
                Route::get('/cart',         [CartController::class, 'index'])->name('app.cart');
                Route::get('/login',         [TenantSiteLoginController::class, 'index'])->name('app.login');
                Route::get('/recuperar-acesso', [AccountRecoverLoginController::class, 'index'])->name('app.recover');
                Route::get('/register',      [TenantSiteRegisterController::class, 'index'])->name('app.register');
                Route::get('/checkout',         [CheckoutController::class, 'index'])->name('app.checkout');
                Route::get('/cliente-area',  [ClientController::class, 'index'])->name('app.client.area');
        
                /**
                 * as rotas abaixo passaram a ser usadas da api
                 */
    
                // Route::group([
                //     'middleware' => ['auth:sanctum']
                // ], function () {
                //     Route::get('/auth/me',                  [TenantSiteLoginController::class, 'me']);
                //     Route::post('/auth/account-update',     [ClientController::class, 'updateAccount']);
                //     Route::post('/auth/account-password',   [ClientController::class, 'updatePasswordAccount']);
    
                //     Route::post('/auth/logout',             [TenantSiteLoginController::class, 'logout']);
    
                //     Route::get('/auth/address',             [TenantSiteLoginController::class, 'getClientAddress']);
                //     Route::post('/auth/newaddress',         [TenantSiteLoginController::class, 'saveNewAddress']);
                //     Route::put('/auth/{id}/address',        [ClientController::class, 'updateAddress']);
                //     Route::delete('/auth/{id}/address',     [ClientController::class, 'deleteAddress']);
                // });
            });
        });
    });
}

Route::prefix('app')->group(function () {

    Route::get('/cart',         [CartController::class, 'index'])->name('cart');
    
    Route::post('/login',        [TenantSiteLoginController::class, 'auth'])->name('app.login.auth');

    Route::post('/recover',         [AccountRecoverLoginController::class, 'sendRecover'])->name('app.recover.send');

    Route::get('/password/reset/{token}',         [AccountRecoverLoginController::class, 'pagePasswordReset'])->name('app.recover.send');
    Route::post('/password/reset',         [AccountRecoverLoginController::class, 'resetPassword'])->name('app.recover.send');

    Route::post('/register',     [TenantSiteRegisterController::class, 'store'])->name('app.register.store');

    Route::get('/tenant',           [TenantSiteTenantController::class, 'getTenant']);
    Route::post('/delivery-price',  [TenantSiteTenantController::class, 'getDeliveryPrice']);
    Route::post('/payment-methods', [TenantSiteTenantController::class, 'getPaymentMethods']);

    Route::get('/category',         [TenantSiteCategoryController::class, 'categories']);
    Route::get('/products',         [TenantSiteProductController::class, 'productsByTenant']);

    Route::get('/site-extensions', [TenantSiteTenantController::class, 'getSiteExtensions']);
});