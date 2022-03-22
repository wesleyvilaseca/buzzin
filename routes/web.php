<?php

use App\Http\Controllers\Admin\ACL\PlanProfileController;
use App\Http\Controllers\Admin\DetailPlanController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PlanController;
use Illuminate\Support\Facades\Route;

Route::get('/admin-home',                   [HomeController::class, 'index'])->name('admin.home');

/**
 * Routes Plans
 */
Route::get('/admin-plan',                   [PlanController::class, 'index'])->name('admin.plan');
Route::post('plans',                        [PlanController::class, 'store'])->name('plans.store');
Route::get('/admin-plan/create',            [PlanController::class, 'create'])->name('plans.create');
Route::put('/admin-plan/{url}',             [PlanController::class, 'update'])->name('plans.update');
Route::get('/admin-plan/{url}/edit',        [PlanController::class, 'edit'])->name('plans.edit');
Route::any('/admin-plan/search',            [PlanController::class, 'search'])->name('plans.search');
Route::delete('/admin-plan/{url}',          [PlanController::class, 'destroy'])->name('plans.destroy');
Route::get('/admin-plan/{url}',             [PlanController::class, 'show'])->name('plans.show');

/**
 * Plan x Profile
 */
Route::get('/admin-plan/{id}/profile/{idProfile}/detach',   [PlanProfileController::class, 'detachProfilePlan'])->name('plans.profile.detach');
Route::post('/admin-plan/{id}/profiles',                    [PlanProfileController::class, 'attachProfilesPlan'])->name('plans.profiles.attach');
Route::any('/admin-plan/{id}/profiles/create',              [PlanProfileController::class, 'profilesAvailable'])->name('plans.profiles.available');
Route::get('/admin-plan{id}/profiles',                      [PlanProfileController::class, 'profiles'])->name('plans.profiles');
Route::get('/admin-profile/{id}/plans',                     [PlanProfileController::class, 'plans'])->name('profiles.plans');


/**
 * Routes Details Plans
 */
Route::delete('/admin-plan/{url}/details/{idDetail}',       [DetailPlanController::class, 'destroy'])->name('details.plan.destroy');
Route::get('/admin-plan/{url}/details/create',              [DetailPlanController::class, 'create'])->name('details.plan.create');
Route::get('/admin-plan/{url}/details/{idDetail}',          [DetailPlanController::class, 'show'])->name('details.plan.show');
Route::put('/admin-plan/{url}/details/{idDetail}',          [DetailPlanController::class, 'update'])->name('details.plan.update');
Route::get('/admin-plan/{url}/details/{idDetail}/edit',     [DetailPlanController::class, 'edit'])->name('details.plan.edit');
Route::post('/admin-plan/{url}/details',                    [DetailPlanController::class, 'store'])->name('details.plan.store');
Route::get('/admin-plan/{url}/details',                     [DetailPlanController::class, 'index'])->name('details.plan.index');


Route::get('/', function () {
    return view('welcome');
});
