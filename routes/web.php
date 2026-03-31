<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

/* --- 1. PUBLIC ROUTES --- */
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/listing/{slug}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/search', [ListingController::class, 'search'])->name('listings.search');

Auth::routes();

/* --- 2. PROTECTED ROUTES --- */
Route::middleware(['auth'])->group(function () {

    Route::get('/approval-notice', function () {
        return view('auth.approval_notice');
    })->name('approval.notice');

    /* --- ADMIN & REGIONAL ADMIN PANEL --- */
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/brokers/pending', [AdminController::class, 'pendingBrokers'])->name('admin.brokers.pending');
        Route::post('/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.approve');

        // USIMAMIZI WA WATUMIAJI
        Route::get('/users', [AdminController::class, 'userIndex'])->name('admin.users.index');
        Route::post('/users/store', [AdminController::class, 'userStore'])->name('admin.users.store');
        Route::post('/users/update/{id}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
        Route::post('/users/toggle/{id}', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');
        Route::delete('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::post('/admin/users/{id}/activate', [App\Http\Controllers\AdminController::class, 'activateSubscription'])->name('admin.users.activate');

        // USIMAMIZI WA MAKUNDI (CATEGORIES) - REKEBISHO HAPA
        Route::get('/categories', [AdminController::class, 'categoryIndex'])->name('admin.categories.index');
        Route::post('/categories/store', [AdminController::class, 'categoryStore'])->name('admin.categories.store');
        Route::post('/categories/update/{id}', [AdminController::class, 'categoryUpdate'])->name('admin.categories.update');
        Route::delete('/categories/delete/{id}', [AdminController::class, 'categoryDelete'])->name('admin.categories.delete');

        // USIMAMIZI WA VYEO (ROLES) - REKEBISHO HAPA
        Route::get('/roles', [AdminController::class, 'roleIndex'])->name('admin.roles.index');
        Route::post('/roles/store', [AdminController::class, 'roleStore'])->name('admin.roles.store');
        Route::post('/roles/update/{id}', [AdminController::class, 'roleUpdate'])->name('admin.roles.update');

        // USIMAMIZI WA BIDHAA
        Route::get('/listings/pending', [AdminController::class, 'pendingListings'])->name('admin.listings.pending');
        Route::post('/listings/approve/{id}', [AdminController::class, 'approveListing'])->name('admin.listings.approve');
        Route::post('/listings/reject/{id}', [AdminController::class, 'rejectListing'])->name('admin.listings.reject');
    });

    /* --- DALALI PANEL --- */
    Route::middleware(['approved'])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/my-listings', [ListingController::class, 'index'])->name('listings.index');



        Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
        Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');
    });
    Route::middleware(['auth', 'approved', 'subscribed'])->group(function () {
        // Routes ambazo dalali lazima awe amelipia ndio azifikie
        Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
        Route::post('/listings/store', [ListingController::class, 'store'])->name('listings.store');
        Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    });
});