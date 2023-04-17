<?php

use App\Http\Controllers\Web\Admin\ACL\PermissionController;
use App\Http\Controllers\Web\Admin\ACL\PermissionProfileController;
use App\Http\Controllers\Web\Admin\ACL\PermissionRoleController;
use App\Http\Controllers\Web\Admin\ACL\PlanProfileController;
use App\Http\Controllers\Web\Admin\ACL\ProfileController;
use App\Http\Controllers\Web\Admin\ACL\RoleController;
use App\Http\Controllers\Web\Admin\ACL\RoleUserController;
use App\Http\Controllers\Web\Admin\CategoryController;
use App\Http\Controllers\Web\Admin\CategoryProductController;
use App\Http\Controllers\Web\Admin\ConfigurationController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\DetailPlanController;
use App\Http\Controllers\Web\Admin\OperationController;
use App\Http\Controllers\Web\Admin\OrderController;
use App\Http\Controllers\Web\Admin\TenantPaymentsController;
use App\Http\Controllers\Web\Admin\PlanController;
use App\Http\Controllers\Web\Admin\ProductController;
use App\Http\Controllers\Web\Admin\SiteController;
use App\Http\Controllers\Web\Admin\SiteExtensionsController;
use App\Http\Controllers\Web\Admin\SiteLayoutController;
use App\Http\Controllers\Web\Admin\SubscriptionController;
use App\Http\Controllers\Web\Admin\TableController;
use App\Http\Controllers\Web\Admin\TenantAccountController;
use App\Http\Controllers\Web\Admin\TenantController;
use App\Http\Controllers\Web\Admin\TenantShippingController;
use App\Http\Controllers\Web\Admin\TransactionsController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Admin\ZonesGeolocationController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Site\HomeController;
use App\Http\Controllers\Web\Site\SubscriptionsController;
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

/**
 * site routes
 */

$domain = request()->getHttpHost();
$appDomain = str_replace(['http://', 'https://'], "", env('APP_URL'));

if ($domain !== $appDomain) {
    Route::middleware(['check.site.client'])->group(function () {
        Route::any('/',         [ClientSiteHomeController::class, 'index']);
        Route::prefix('app')->group(function () {
            Route::get('/cart',         [CartController::class, 'index'])->name('cart');

            Route::get('/login',         [TenantSiteLoginController::class, 'index'])->name('app.login');
            Route::post('/login',        [TenantSiteLoginController::class, 'auth'])->name('app.login.auth');

            Route::get('/recuperar-acesso', [AccountRecoverLoginController::class, 'index'])->name('app.recover');
            Route::post('/recover',         [AccountRecoverLoginController::class, 'sendRecover'])->name('app.recover.send');

            Route::get('/password/reset/{token}',         [AccountRecoverLoginController::class, 'pagePasswordReset'])->name('app.recover.send');
            Route::post('/password/reset',         [AccountRecoverLoginController::class, 'resetPassword'])->name('app.recover.send');

            Route::get('/register',      [TenantSiteRegisterController::class, 'index'])->name('app.register');
            Route::post('/register',     [TenantSiteRegisterController::class, 'store'])->name('app.register.store');

            Route::get('/tenant',           [TenantSiteTenantController::class, 'getTenant']);
            Route::post('/delivery-price',  [TenantSiteTenantController::class, 'getDeliveryPrice']);
            Route::post('/payment-methods', [TenantSiteTenantController::class, 'getPaymentMethods']);

            Route::get('/category',         [TenantSiteCategoryController::class, 'categories']);
            Route::get('/products',         [TenantSiteProductController::class, 'productsByTenant']);

            Route::get('/checkout',         [CheckoutController::class, 'index']);

            Route::get('/cliente-area',  [ClientController::class, 'index']);

            Route::get('/site-extensions', [TenantSiteTenantController::class, 'getSiteExtensions']);

            Route::group([
                'middleware' => ['auth:sanctum']
            ], function () {
                Route::get('/auth/me',                  [TenantSiteLoginController::class, 'me']);
                Route::post('/auth/account-update',     [ClientController::class, 'updateAccount']);
                Route::post('/auth/account-password',   [ClientController::class, 'updatePasswordAccount']);

                Route::post('/auth/logout',             [TenantSiteLoginController::class, 'logout']);

                Route::get('/auth/address',             [TenantSiteLoginController::class, 'getClientAddress']);
                Route::post('/auth/newaddress',         [TenantSiteLoginController::class, 'saveNewAddress']);
                Route::put('/auth/{id}/address',        [ClientController::class, 'updateAddress']);
                Route::delete('/auth/{id}/address',     [ClientController::class, 'deleteAddress']);

                Route::post('/checkout/order',          [CheckoutController::class, 'store']);
                Route::get('/auth/my-orders',           [ClientController::class, 'getOrders']);
            });
        });
    });

    Route::any('/site-em-manutencao',         [ClientSiteHomeController::class, 'inMaintence'])->name('tenant.maintence');
    return;
}