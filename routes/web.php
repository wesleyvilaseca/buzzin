<?php

use App\Http\Controllers\Admin\ACL\PlanProfileController;
use App\Http\Controllers\Admin\DetailPlanController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PlanController;
use Illuminate\Support\Facades\Route;

Route::get('/admin-home',                   [HomeController::class, 'index'])->name('admin.home');

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
    Route::get('/{id}/profile',                     [PlanProfileController::class, 'plans'])->name('profiles.plans');

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

Route::get('/', function () {
    return view('welcome');
});
