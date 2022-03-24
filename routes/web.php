<?php

use App\Http\Controllers\Admin\ACL\PermissionController;
use App\Http\Controllers\Admin\ACL\PermissionProfileController;
use App\Http\Controllers\Admin\ACL\PlanProfileController;
use App\Http\Controllers\Admin\ACL\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DetailPlanController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/**
 * register routes
 */
Route::get('/register',     [RegisterController::class, 'index'])->name('register');
Route::post('/register',    [RegisterController::class, 'create'])->name('register.create');

/**
 * login routes
 */

Route::get('/login',        [LoginController::class, 'index'])->name('login');
Route::post('/login',       [LoginController::class, 'auth'])->name('login.auth');
Route::post('/logout',      [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function() {
    Route::get('/admin-dashboard',                   [DashboardController::class, 'index'])->name('admin.dashboard');

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
    
});

// Route::get('/', function () {
//     return view('welcome');
// });