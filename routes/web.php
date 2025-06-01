<?php

use App\Http\Controllers\Admin\BatchController as AdminBatchController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
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
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ITSaleScraperController as AdminITSaleScraperController;
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
Route::post('/contact', [InquiryController::class, 'store'])->name('contact.store');

// Product routes
Route::get('/available-stock', [ProductController::class, 'index'])->name('products.index');
Route::get('/available-stock/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/available-stock/{product}/inquiry', [InquiryController::class, 'storeProductInquiry'])->name('products.inquiry');

// Authentication routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    // Password Reset
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    
    // Custom Registration
    Route::get('/register-b2b', [RegisterController::class, '__invoke'])->name('register.b2b');
    Route::post('/register-b2b', [RegisterController::class, 'store'])->name('register.b2b.store');
});

// Auth routes that require authentication
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
    
    // Customer routes
    Route::post('/available-stock/{product}/reserve', [ProductController::class, 'reserve'])->name('products.reserve');
    Route::get('/my-reservations', [ProductController::class, 'myReservations'])->name('my-reservations');
});

// Admin routes
Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/images', [AdminProductController::class, 'uploadImage'])->name('products.images.store');
    Route::delete('products/{product}/images/{image}', [AdminProductController::class, 'deleteImage'])->name('products.images.destroy');
    Route::post('products/{product}/specifications', [AdminProductController::class, 'addSpecification'])->name('products.specifications.store');
    Route::delete('products/{product}/specifications/{specification}', [AdminProductController::class, 'deleteSpecification'])->name('products.specifications.destroy');
    
    // Batches
    Route::resource('batches', AdminBatchController::class);
    
    // Categories
    Route::resource('categories', AdminCategoryController::class);
    
    // Third-Party Suppliers
    Route::resource('suppliers', AdminThirdPartySupplierController::class);
    Route::get('suppliers/{supplier}/configure', [AdminThirdPartySupplierController::class, 'configureCredentials'])->name('suppliers.configure');
    Route::post('suppliers/{supplier}/configure', [AdminThirdPartySupplierController::class, 'updateCredentials'])->name('suppliers.update-credentials');
    Route::get('suppliers/{supplier}/itsale-scraper', [AdminThirdPartySupplierController::class, 'showItsaleScraper'])->name('suppliers.itsale-scraper');
    
    // ITSale.pl Scraper
    Route::get('itsale/{supplier}', [AdminITSaleScraperController::class, 'index'])->name('itsale.index');
    Route::get('itsale/{supplier}/list/{listSlug}', [AdminITSaleScraperController::class, 'showList'])->name('itsale.show-list');
    
    // Orders
    Route::resource('orders', AdminOrderController::class);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    
    // Inquiries
    Route::resource('inquiries', AdminInquiryController::class)->except(['create', 'store']);
    Route::patch('inquiries/{inquiry}/status', [AdminInquiryController::class, 'updateStatus'])->name('inquiries.status');
    
    // Users
    Route::resource('users', AdminUserController::class);
    Route::patch('users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
});

// Default Breeze redirect
Route::redirect('/dashboard', '/');
