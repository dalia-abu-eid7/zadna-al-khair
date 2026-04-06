<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\CharityRegisterController;
use App\Http\Controllers\Restaurant\RestaurantDashboardController;
use App\Http\Controllers\Association\AssociationDashboardController;

// 1. الصفحة الرئيسية
Route::get('/', function () { return view('welcome'); });

// 2. مسارات تسجيل المطعم (Restaurant)
Route::prefix('register/restaurant')->group(function () {
    Route::get('/', [RegisterController::class, 'showRegistrationForm'])->name('restaurant.register');
    Route::post('/step2', [RegisterController::class, 'showRegistrationStep2'])->name('restaurant.register.step2');
    Route::post('/store', [RegisterController::class, 'registerRestaurant'])->name('restaurant.register.post');
});

// 3. مسارات تسجيل الجمعية (Charity)
Route::prefix('register/charity')->group(function () {
    Route::get('/', [CharityRegisterController::class, 'showRegistrationForm'])->name('charity.register');
Route::match(['get', 'post'], '/step2', [CharityRegisterController::class, 'showRegistrationStep2'])->name('charity.register.step2');    Route::post('/store', [CharityRegisterController::class, 'registerCharity'])->name('charity.register.post');
});

// 4. مسارات تسجيل الدخول والخروج
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 5. مسارات محمية (يجب تسجيل الدخول للوصول إليها)
Route::middleware(['auth'])->group(function () {

    // --- لوحة تحكم الأدمن ---

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/entities', [AdminDashboardController::class, 'manageEntities'])->name('entities');
    Route::post('/entities/toggle/{id}', [AdminDashboardController::class, 'toggleUserStatus'])->name('entities.toggle');
    Route::get('/users', [AdminDashboardController::class, 'manageUsers'])->name('users');
    Route::get('/donations', [AdminDashboardController::class, 'manageDonations'])->name('donations');
    Route::post('/users/toggle/{id}', [AdminDashboardController::class, 'toggleUserStatus'])->name('users.toggle');
    Route::get('/export-stats', [AdminDashboardController::class, 'exportStats'])->name('export.stats');
    Route::delete('/users/delete/{id}', [AdminDashboardController::class, 'deleteUser'])->name('users.delete');
});


  // --- مسارات المطعم ---
Route::prefix('restaurant')->name('restaurant.')->group(function() {
    Route::get('/dashboard', [RestaurantDashboardController::class, 'index'])->name('dashboard');
    Route::get('/add-donation', [RestaurantDashboardController::class, 'createDonation'])->name('add_donation');
    Route::post('/store-donation', [RestaurantDashboardController::class, 'storeDonation'])->name('store_donation');
    Route::get('/donations-list', [RestaurantDashboardController::class, 'donationsList'])->name('donations_list');
    Route::get('/partners-list', [RestaurantDashboardController::class, 'showPartners'])->name('partners_list');

    // مسارات التعديل والحذف
    Route::get('/donations/edit/{id}', [RestaurantDashboardController::class, 'editDonation'])->name('donations.edit');
    Route::put('/donations/update/{id}', [RestaurantDashboardController::class, 'updateDonation'])->name('donations.update');
    Route::delete('/donations/destroy/{id}', [RestaurantDashboardController::class, 'destroyDonation'])->name('donations.destroy');
});


// --- مسارات الجمعية ---
Route::prefix('association')->name('association.')->group(function() {
    Route::get('/dashboard', [AssociationDashboardController::class, 'index'])->name('dashboard');
    Route::get('/available-donations', [AssociationDashboardController::class, 'availableDonations'])->name('available_donations');
    Route::post('/accept-donation/{id}', [AssociationDashboardController::class, 'acceptDonation'])->name('accept_donation');
    Route::get('/accepted-donations', [AssociationDashboardController::class, 'acceptedDonations'])->name('accepted_donations');
    Route::post('/confirm-receipt/{id}', [AssociationDashboardController::class, 'confirm_receipt'])->name('confirm_receipt');

    Route::get('/partner-restaurants', [AssociationDashboardController::class, 'partnerRestaurants'])
         ->name('partner_restaurants');
});

});
