<?php

use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\BatchController as AdminBatchController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ThirdPartySupplierController as AdminThirdPartySupplierController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ITSaleScraperController as AdminITSaleScraperController;
use App\Http\Controllers\Admin\ITSaleScraperController as ITSaleScraperController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/how-it-works', [HomeController::class, 'howItWorks'])->name('how-it-works');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/cookies', [HomeController::class, 'cookies'])->name('cookies');
Route::post('/contact', [InquiryController::class, 'store'])->name('contact.store');

// Batches routes
Route::get('/batches', [App\Http\Controllers\BatchesController::class, 'index'])->name('batches.index');
Route::get('/batches/{batch}', [App\Http\Controllers\BatchesController::class, 'show'])->name('batches.show');

// Categories routes
Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [App\Http\Controllers\CategoriesController::class, 'show'])->name('categories.show');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('register-b2b', [RegisterController::class, 'showRegistrationForm'])->name('register.b2b');
    Route::post('register-b2b', [RegisterController::class, 'register']);
    
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Email Verification
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    
    // Password Confirmation
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    
    // Password Update
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Batches
    Route::resource('batches', AdminBatchController::class);
    
    // Batch product management routes
    Route::get('batches/{batch}/manage-products', [AdminBatchController::class, 'manageProducts'])->name('batches.manage-products');
    Route::post('batches/{batch}/add-product', [AdminBatchController::class, 'addProduct'])->name('batches.add-product');
    Route::delete('batches/{batch}/remove-product/{index}', [AdminBatchController::class, 'removeProduct'])->name('batches.remove-product');
    Route::get('batches/{batch}/print-label', [AdminBatchController::class, 'printLabel'])->name('batches.print-label');
    Route::get('batches/{batch}/print-product-labels', [AdminBatchController::class, 'printProductLabels'])->name('batches.print-product-labels');
    Route::get('batches/{batch}/generate-pdf', [AdminBatchController::class, 'generatePdf'])->name('batches.generate-pdf');
    Route::get('batches/{batch}/download-product-labels', [AdminBatchController::class, 'downloadProductLabelsPdf'])->name('batches.download-product-labels');
    
    // Categories
    Route::resource('categories', AdminCategoryController::class);
    
    // Third-Party Suppliers
    Route::resource('suppliers', AdminThirdPartySupplierController::class);
    Route::get('suppliers/{supplier}/configure', [AdminThirdPartySupplierController::class, 'configureCredentials'])->name('suppliers.configure');
    Route::post('suppliers/{supplier}/configure', [AdminThirdPartySupplierController::class, 'updateCredentials'])->name('suppliers.update-credentials');
    
    // ITSale Scraper
    Route::get('itsale/scraper/{supplier?}', [AdminITSaleScraperController::class, 'index'])->name('itsale.scraper');
    Route::get('itsale/scraper/{supplier?}/{listSlug}', [AdminITSaleScraperController::class, 'showList'])->name('itsale.scraper.show-list');
    Route::get('itsale/scraper/{supplier?}/{listSlug}/import-batch', [AdminITSaleScraperController::class, 'showImportForm'])->name('itsale.scraper.show-import-form');
    Route::post('itsale/scraper/{supplier?}/{listSlug}/import-batch', [AdminITSaleScraperController::class, 'importAsBatch'])->name('itsale.scraper.import-batch');
    
    // Orders
    Route::resource('orders', AdminOrderController::class);
    
    // Inquiries
    Route::resource('inquiries', AdminInquiryController::class);
    
    // Users
    Route::resource('users', AdminUserController::class);
});

