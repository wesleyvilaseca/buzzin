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

            Route::group([
                'middleware' => ['auth:sanctum']
            ], function () {
                Route::get('/auth/me',                  [TenantSiteLoginController::class, 'me']);
                Route::post('/auth/account-update',      [ClientController::class, 'updateAccount']);
                Route::post('/auth/account-password',     [ClientController::class, 'updatePasswordAccount']);

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

Route::get('/',             [HomeController::class, 'index'])->name('inicio');
Route::get('/subscription/{url}', [SubscriptionsController::class, 'plan'])->name('subscription');
Route::post('/subscription/{url}', [SubscriptionsController::class, 'register'])->name('subscription.register');

/**
 * register routes
 */
// Route::get('/register',     [RegisterController::class, 'index'])->name('register');
// Route::post('/register',    [RegisterController::class, 'create'])->name('register.create');

/**
 * login routes
 */

Route::get('/login',       [LoginController::class, 'index'])->name('login');
Route::post('/login',      [LoginController::class, 'auth'])->name('login.auth');
Route::get('/logout',      [LoginController::class, 'logout'])->name('logout');

Route::get('/recover',      [LoginController::class, 'recover'])->name('recover');
Route::post('/recover',     [LoginController::class, 'sendRecover'])->name('recover');

Route::get('/password/reset/{token}',     [LoginController::class, 'newPassword'])->name('reset_password');
Route::post('/password/reset',            [LoginController::class, 'resetPasswordStore'])->name('reset_password.store');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin-dashboard',                   [DashboardController::class, 'index'])->name('admin.dashboard');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    Route::prefix('admin-subscriptions')->group(function () {
        Route::get('/',            [SubscriptionController::class, 'index'])->name('admin.subscriptions');
    });

    Route::prefix('admin-transactions')->group(function () {
        Route::get('/',            [TransactionsController::class, 'index'])->name('admin.transactions');
    });

    Route::prefix('admin-permissions')->group(function () {
        /**
         * permissions
         */
        Route::get('/',            [PermissionController::class, 'index'])->name('admin.permissions');
        Route::get('/create',      [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/',           [PermissionController::class, 'store'])->name('permissions.store');

        Route::get('/{id}/edit',   [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/{id}',        [PermissionController::class, 'update'])->name('permissions.update');

        Route::get('/{id}/show',   [PermissionController::class, 'show'])->name('permissions.show');
        Route::delete('/{id}',     [PermissionController::class, 'destroy'])->name('permissions.destroy');

        Route::any('/search',      [PermissionController::class, 'search'])->name('permissions.search');
    });

    Route::prefix('admin-roles')->group(function () {
        /**
         * routes roles
         */
        Route::get('/',            [RoleController::class, 'index'])->name('admin.roles');
        Route::get('/create',      [RoleController::class, 'create'])->name('role.create');
        Route::post('/',           [RoleController::class, 'store'])->name('role.store');

        Route::get('/{id}/edit',   [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/{id}',        [RoleController::class, 'update'])->name('role.update');

        Route::get('/{id}/show',   [RoleController::class, 'show'])->name('role.show');
        Route::delete('/{id}',     [RoleController::class, 'destroy'])->name('role.destroy');

        Route::any('/search',      [RoleController::class, 'search'])->name('role.search');

        /**
         * Permission x Role
         */
        Route::get('{id}/permission/{idPermission}/detach', [PermissionRoleController::class, 'detachPermissionRole'])->name('roles.permission.detach');
        Route::post('{id}/permissions',                     [PermissionRoleController::class, 'attachPermissionsRole'])->name('roles.permissions.attach');
        Route::any('{id}/permissions/create',               [PermissionRoleController::class, 'permissionsAvailable'])->name('roles.permissions.available');
        Route::get('{id}/permissions',                      [PermissionRoleController::class, 'permissions'])->name('roles.permissions');
        Route::get('permissions/{id}/role',                 [PermissionRoleController::class, 'roles'])->name('permissions.roles');
    });

    Route::prefix('admin-plan')->group(function () {
        /**
         * Routes Plans
         */
        Route::get('/',                  [PlanController::class, 'index'])->name('admin.plan');
        Route::post('/',                 [PlanController::class, 'store'])->name('plans.store');
        Route::get('/create',            [PlanController::class, 'create'])->name('plans.create');
        Route::put('/{url}',             [PlanController::class, 'update'])->name('plans.update');
        Route::get('/{url}/edit',        [PlanController::class, 'edit'])->name('plans.edit');
        Route::any('/search',            [PlanController::class, 'search'])->name('plans.search');
        Route::delete('/{url}',          [PlanController::class, 'destroy'])->name('plans.destroy');
        Route::get('/{url}',             [PlanController::class, 'show'])->name('plans.show');

        /**
         * Plan x Profile
         */
        Route::get('/{id}/profile/{idProfile}/detach',   [PlanProfileController::class, 'detachProfilePlan'])->name('plans.profile.detach');
        Route::post('/{id}/profiles',                    [PlanProfileController::class, 'attachProfilesPlan'])->name('plans.profiles.attach');
        Route::any('/{id}/profiles/create',              [PlanProfileController::class, 'profilesAvailable'])->name('plans.profiles.available');
        Route::get('{id}/profiles',                      [PlanProfileController::class, 'profiles'])->name('plans.profiles');
        Route::get('/{id}/profile',                      [PlanProfileController::class, 'plans'])->name('profiles.plans');

        /**
         * Routes Details Plans
         */
        Route::delete('/{url}/details/{idDetail}',       [DetailPlanController::class, 'destroy'])->name('details.plan.destroy');
        Route::get('/{url}/details/create',              [DetailPlanController::class, 'create'])->name('details.plan.create');
        Route::get('/{url}/details/{idDetail}',          [DetailPlanController::class, 'show'])->name('details.plan.show');
        Route::put('/{url}/details/{idDetail}',          [DetailPlanController::class, 'update'])->name('details.plan.update');
        Route::get('/{url}/details/{idDetail}/edit',     [DetailPlanController::class, 'edit'])->name('details.plan.edit');
        Route::post('/{url}/details',                    [DetailPlanController::class, 'store'])->name('details.plan.store');
        Route::get('/{url}/details',                     [DetailPlanController::class, 'index'])->name('details.plan.index');
    });

    Route::prefix('admin-profiles')->group(function () {
        /**
         * routes profiles
         */
        Route::get('/',            [ProfileController::class, 'index'])->name('admin.profiles');
        Route::get('/create',      [ProfileController::class, 'create'])->name('profiles.create');
        Route::post('/',           [ProfileController::class, 'store'])->name('profiles.store');

        Route::get('/{id}/edit',   [ProfileController::class, 'edit'])->name('profiles.edit');
        Route::put('/{id}',        [ProfileController::class, 'update'])->name('profiles.update');

        Route::get('/{id}/show',   [ProfileController::class, 'show'])->name('profiles.show');
        Route::delete('/{id}',     [ProfileController::class, 'destroy'])->name('profiles.destroy');

        Route::any('/search',      [ProfileController::class, 'search'])->name('profiles.search');

        /**
         * permissions x profile
         */
        Route::get('{id}/permission/{idPermission}/detach',         [PermissionProfileController::class, 'detachPermissionProfile'])->name('profiles.permission.detach');
        Route::post('{id}/permissions',                             [PermissionProfileController::class, 'attachPermissionsProfile'])->name('profiles.permissions.attach');
        Route::any('{id}/permissions/create',                       [PermissionProfileController::class, 'permissionsAvailable'])->name('profiles.permissions.available');
        Route::get('{id}/permission',                               [PermissionProfileController::class, 'permissions'])->name('profile.permissions');
        Route::get('{id}/permissions',                              [PermissionProfileController::class, 'profiles'])->name('permissions.profiles');
    });

    Route::prefix('admin-tenants')->group(function () {
        /**
         * Routes tenants
         */
        Route::get('/',                  [TenantController::class, 'index'])->name('admin.tenants');
        Route::get('/create',            [TenantController::class, 'create'])->name('tenant.create');
        Route::post('/',                 [TenantController::class, 'store'])->name('tenant.store');
        Route::put('/{id}',              [TenantController::class, 'update'])->name('tenant.update');
        Route::get('/{id}/edit',         [TenantController::class, 'edit'])->name('tenant.edit');
        Route::any('/search',            [TenantController::class, 'search'])->name('tenant.search');
        Route::get('/{id}',             [TenantController::class, 'show'])->name('tenant.show');
        Route::delete('/{id}',          [TenantController::class, 'destroy'])->name('tenant.destroy');

        Route::post('/order-when-closed',   [TenantController::class, 'orderWhenClosed'])->name('tenant.order_when_closed');
        Route::post('/open-place',          [TenantController::class, 'open'])->name('tenant.open');
    });

    Route::middleware(['check.subscrition.tenant'])->group(function () {
        Route::prefix('admin-zones')->group(function () {
            /**
             * routes zones
             */
            Route::get('/',            [ZonesGeolocationController::class, 'index'])->name('admin.zones.geolocation');
            Route::get('/create', [ZonesGeolocationController::class, 'create'])->name('zone.geolocation.create');
            Route::post('/create', [ZonesGeolocationController::class, 'store'])->name('zone.geolocation.store');
            Route::get('/{id}/edit',   [ZonesGeolocationController::class, 'edit'])->name('zone.geolocation.edit');
            Route::put('/{id}/edit',   [ZonesGeolocationController::class, 'update'])->name('zone.geolocation.update');
            // Route::get('/create',      [ProfileController::class, 'create'])->name('profiles.create');
            // Route::post('/',           [ProfileController::class, 'store'])->name('profiles.store');

            // Route::put('/{id}',        [ProfileController::class, 'update'])->name('profiles.update');

            // Route::get('/{id}/show',   [ProfileController::class, 'show'])->name('profiles.show');
            // Route::delete('/{id}',     [ProfileController::class, 'destroy'])->name('profiles.destroy');

            // Route::any('/search',      [ProfileController::class, 'search'])->name('profiles.search');

            /**
             * permissions x profile
             */
            Route::get('{id}/permission/{idPermission}/detach',         [PermissionProfileController::class, 'detachPermissionProfile'])->name('profiles.permission.detach');
            Route::post('{id}/permissions',                             [PermissionProfileController::class, 'attachPermissionsProfile'])->name('profiles.permissions.attach');
            Route::any('{id}/permissions/create',                       [PermissionProfileController::class, 'permissionsAvailable'])->name('profiles.permissions.available');
            Route::get('{id}/permission',                               [PermissionProfileController::class, 'permissions'])->name('profile.permissions');
            Route::get('{id}/permissions',                              [PermissionProfileController::class, 'profiles'])->name('permissions.profiles');
        });

        Route::prefix('admin-user')->group(function () {
            /**
             * Routes users
             */
            Route::get('/',                  [UserController::class, 'index'])->name('admin.users');
            Route::get('/create',            [UserController::class, 'create'])->name('user.create');
            Route::post('/',                 [UserController::class, 'store'])->name('user.store');
            Route::put('/{id}',              [UserController::class, 'update'])->name('user.update');
            Route::get('/{id}/edit',         [UserController::class, 'edit'])->name('user.edit');
            Route::any('/search',            [UserController::class, 'search'])->name('user.search');
            Route::get('/{id}',             [UserController::class, 'show'])->name('user.show');
            Route::delete('/{id}',          [UserController::class, 'destroy'])->name('user.destroy');


            /**
             * Role x User
             */
            Route::get('{id}/role/{idRole}/detach', [RoleUserController::class, 'detachRoleUser'])->name('users.role.detach');
            Route::post('{id}/roles', [RoleUserController::class, 'attachRolesUser'])->name('users.roles.attach');
            Route::any('{id}/roles/create', [RoleUserController::class, 'rolesAvailable'])->name('users.roles.available');
            Route::get('{id}/roles', [RoleUserController::class, 'roles'])->name('users.roles');
            Route::get('{id}/users', [RoleUserController::class, 'users'])->name('roles.users');
        });

        Route::prefix('admin-category')->group(function () {
            /**
             * Routes categories
             */
            Route::get('/',                  [CategoryController::class, 'index'])->name('admin.categories');
            Route::get('/create',            [CategoryController::class, 'create'])->name('category.create');
            Route::post('/',                 [CategoryController::class, 'store'])->name('category.store');
            Route::put('/{id}',              [CategoryController::class, 'update'])->name('category.update');
            Route::get('/{id}/edit',         [CategoryController::class, 'edit'])->name('category.edit');
            Route::any('/search',            [CategoryController::class, 'search'])->name('category.search');
            Route::get('/{id}',             [CategoryController::class, 'show'])->name('category.show');
            Route::delete('/{id}',          [CategoryController::class, 'destroy'])->name('category.destroy');
        });

        Route::prefix('admin-product')->group(function () {
            /**
             * Routes products
             */
            Route::get('/',                  [ProductController::class, 'index'])->name('admin.products');
            Route::get('/create',            [ProductController::class, 'create'])->name('product.create');
            Route::post('/',                 [ProductController::class, 'store'])->name('product.store');
            Route::put('/{id}',              [ProductController::class, 'update'])->name('product.update');
            Route::get('/{id}/edit',         [ProductController::class, 'edit'])->name('product.edit');
            Route::any('/search',            [ProductController::class, 'search'])->name('product.search');
            Route::get('/{id}',             [ProductController::class, 'show'])->name('product.show');
            Route::delete('/{id}',          [ProductController::class, 'destroy'])->name('product.destroy');

            /**
             * Product x Category
             */
            Route::get('{id}/category/{idCategory}/detach', [CategoryProductController::class, 'detachCategoryProduct'])->name('products.category.detach');
            Route::post('{id}/categories', [CategoryProductController::class, 'attachCategoriesProduct'])->name('products.categories.attach');
            Route::any('{id}/categories/create', [CategoryProductController::class, 'categoriesAvailable'])->name('products.categories.available');
            Route::get('{id}/categories',  [CategoryProductController::class, 'categories'])->name('product.categories');
            Route::get('{id}/products',  [CategoryProductController::class, 'products'])->name('categories.products');
        });

        Route::prefix('admin-table')->group(function () {
            /**
             * Routes products
             */
            Route::get('/',                  [TableController::class, 'index'])->name('admin.tables');
            Route::get('/create',            [TableController::class, 'create'])->name('table.create');
            Route::post('/',                 [TableController::class, 'store'])->name('table.store');
            Route::put('/{id}',              [TableController::class, 'update'])->name('table.update');
            Route::get('/{id}/edit',         [TableController::class, 'edit'])->name('table.edit');
            Route::any('/search',            [TableController::class, 'search'])->name('table.search');
            Route::get('/{id}',             [TableController::class, 'show'])->name('table.show');
            Route::delete('/{id}',          [TableController::class, 'destroy'])->name('table.destroy');

            Route::get('tables/qrcode/{identify}', [TableController::class, 'qrcode'])->name('table.qrcode');
        });

        Route::prefix('admin-site')->group(function () {
            Route::get('/',                 [SiteController::class, 'index'])->name('admin.site');
            Route::post('/',                [SiteController::class, 'enable'])->name('admin.site.enable');
            Route::post('/layout',          [SiteController::class, 'storeUpdateLayout'])->name('admin.site.layout');
        });

        Route::prefix('admin-payment')->group(function () {
            Route::get('/',                 [TenantPaymentsController::class, 'index'])->name('admin.payments');
            Route::post('/active',          [TenantPaymentsController::class, 'active'])->name('payment.active');
            Route::put('/disable/{id}',     [TenantPaymentsController::class, 'disable'])->name('payment.disable');
            Route::put('/enable/{id}',      [TenantPaymentsController::class, 'enable'])->name('payment.enable');
        });

        Route::prefix('admin-shipping')->group(function () {
            Route::get('/',                 [TenantShippingController::class, 'index'])->name('admin.shippings');
            Route::post('/active',          [TenantShippingController::class, 'active'])->name('shipping.active');
            Route::put('/disable/{id}',     [TenantShippingController::class, 'disable'])->name('shipping.disable');
            Route::put('/enable/{id}',      [TenantShippingController::class, 'enable'])->name('shipping.enable');
        });

        Route::prefix('admin-operation')->group(function () {
            Route::get('/',                 [OperationController::class, 'index'])->name('admin.operations');
            Route::post('/active',          [OperationController::class, 'active'])->name('operation.active');
            Route::put('/disable/{id}',     [OperationController::class, 'disable'])->name('operation.disable');
            Route::put('/enable/{id}',      [OperationController::class, 'enable'])->name('operation.enable');
            Route::get('/{id}/detail',      [OperationController::class, 'detailOperation'])->name('operation.detail');

            Route::post('/{id}/detail',      [OperationController::class, 'detailStore'])->name('operation.store');
            Route::post('/{id}/delete',      [OperationController::class, 'detailDelete'])->name('operation.delete');
        });

        Route::prefix('admin-myaccount')->group(function () {
            Route::get('/',                 [TenantAccountController::class, 'index'])->name('admin.myaccount');
            Route::put('/update-password',  [TenantAccountController::class, 'updatePassword'])->name('update.passwordaccount');
            Route::put('/update-data',      [TenantAccountController::class, 'updateData'])->name('update.dataaccount');
        });

        Route::prefix('admin-configuration')->group(function () {
            Route::get('/',                 [ConfigurationController::class, 'index'])->name('admin.configuration');
        });
    });
});
