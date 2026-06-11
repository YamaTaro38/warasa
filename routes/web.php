<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductGeneratorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoasCalculatorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ShopeeFeeCalculatorController;
use App\Http\Controllers\DocumentationController as PublicDocumentationController;
use App\Http\Controllers\Admin\DocumentationController;
use App\Http\Controllers\Admin\ApiKeyController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ShopeeFeeConfigController;
use App\Http\Controllers\Admin\AdminSettingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ProductExportController;
use App\Livewire\ProductExport;


// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Redirect /features and /pricing to home (hidden until launch)
Route::redirect('/features', '/');
Route::redirect('/pricing', '/');

// ==================== PUBLIC DOCUMENTATION ====================
Route::get('/docs', [PublicDocumentationController::class, 'index'])->name('docs');
Route::get('/docs/{slug}', [PublicDocumentationController::class, 'show'])->name('docs.show');

// ==================== CUSTOM AUTH ROUTES ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Google OAuth Routes
    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

 Route::get('/products/export-page', function () {
        return view('products.export-page');
    })->name('products.export.page');

// ==================== PROTECTED ROUTES ====================
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/resend-verification', [ProfileController::class, 'resendVerification'])->name('profile.resend-verification');

    
    // ==================== PRODUCT GENERATOR ====================
    Route::middleware('menu.visible')->group(function () {
        Route::get('/generator', [ProductGeneratorController::class, 'index'])->name('generator');
        Route::get('/generator/quick', [ProductGeneratorController::class, 'quickGenerate'])->name('generator.quick');
        Route::get('/generator/smart', [ProductGeneratorController::class, 'smartGenerate'])->name('generator.smart');
        Route::post('/generator/upload-csv', [ProductGeneratorController::class, 'uploadCsv'])->name('generator.upload-csv');
        Route::post('/generator/generate-complete', [ProductGeneratorController::class, 'generateComplete'])->name('generator.generate-complete');
        Route::post('/generator/generate-image', [ProductGeneratorController::class, 'generateImage'])->name('generator.generate-image');
        Route::post('/generator/save', [ProductGeneratorController::class, 'save'])->name('generator.save');
        Route::post('/generator/upload-image', [ImageUploadController::class, 'upload'])->name('generator.upload-image');
        Route::post('/generator/apply-watermark', [ProductGeneratorController::class, 'applyWatermark'])->name('generator.apply-watermark');
        Route::post('/generator/analyze-competitor', [ProductGeneratorController::class, 'analyzeCompetitor'])->name('generator.analyze-competitor');
        Route::post('/generator/seo-score', [ProductGeneratorController::class, 'seoScore'])->name('generator.seo-score');
    });


    // Projects
    Route::resource('projects', ProjectController::class);
    Route::post('/projects/{project}/archive', [ProjectController::class, 'archive'])->name('projects.archive');
    Route::post('/projects/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    
    // Products
    Route::middleware('menu.visible')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product:uuid}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product:uuid}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product:uuid}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product:uuid}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{product:uuid}/archive', [ProductController::class, 'archive'])->name('products.archive');
    Route::get('/products/{product:uuid}/duplicate', [ProductController::class, 'duplicate'])->name('products.duplicate');
    Route::post('/products/export', [ProductController::class, 'export'])->name('products.export');
    
    Route::post('/products/export-shopee', [ProductExportController::class, 'exportToShopee'])->name('products.export.shopee');
    Route::get('/products/export-single/{uuid}', [ProductExportController::class, 'exportSingle'])->name('products.export.single');

    Route::post('/products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
    Route::post('/products/{product:uuid}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    }); // Close products menu.visible group

    Route::get('categories/list', [CategoryController::class, 'list'])->name('categories.list');
    
    // Chatbot
    Route::middleware('menu.visible')->group(function () {
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
    Route::post('/chatbot/send', [ChatbotController::class, 'send'])->name('chatbot.send');
    Route::get('/chatbot/sessions', [ChatbotController::class, 'sessions'])->name('chatbot.sessions');
    Route::get('/chatbot/session/{session}/load', [ChatbotController::class, 'loadSession'])->name('chatbot.session.load');
    Route::delete('/chatbot/session/{session}', [ChatbotController::class, 'destroySession'])->name('chatbot.session.destroy');
    Route::get('/chatbot/session/{session}/export', [ChatbotController::class, 'exportSession'])->name('chatbot.session.export');
    }); // Close chatbot menu.visible group

    Route::middleware('menu.visible')->group(function () {
    Route::get('/roas-calculator', [RoasCalculatorController::class, 'index'])->name('roas.calculator');
    Route::post('/roas-calculator/calculate', [RoasCalculatorController::class, 'calculate'])->name('roas.calculate');
    }); // Close roas menu.visible group

    Route::middleware('menu.visible')->group(function () {
    Route::get('/shopee-fee-calculator', [ShopeeFeeCalculatorController::class, 'index'])->name('shopee.fee.calculator');
    Route::post('/shopee-fee-calculator/calculate', [ShopeeFeeCalculatorController::class, 'calculate'])->name('shopee.fee.calculate');
    }); // Close shopee fee menu.visible group

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/profile')->with('success', 'Email verified successfully!');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::post('/email/verification-notification', [ProfileController::class, 'resendVerification'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('users.show');
    Route::post('/users/{user}/suspend', [AdminController::class, 'userSuspend'])->name('users.suspend');
    Route::post('/users/{user}/activate', [AdminController::class, 'userActivate'])->name('users.activate');
    Route::delete('/users/{user}', [AdminController::class, 'userDelete'])->name('users.delete');

    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category:uuid',
    ]);
    Route::post('categories/{category:uuid}/toggle-active', [CategoryController::class, 'toggleActive'])->name('categories.toggle-active');

    Route::resource('api-keys', ApiKeyController::class);
    Route::post('api-keys/check-now', [ApiKeyController::class, 'checkNow'])->name('api-keys.check-now');

    // Menu Visibility Management
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('/menus/{menu}/toggle', [MenuController::class, 'toggle'])->name('menus.toggle');
    Route::put('/menus/bulk', [MenuController::class, 'updateBulk'])->name('menus.update-bulk');
    Route::put('/menus/sort-order', [MenuController::class, 'updateSortOrder'])->name('menus.sort-order');

    // Shopee Fee Configuration
    Route::get('/shopee-fees', [ShopeeFeeConfigController::class, 'index'])->name('shopee-fees.index');
    Route::put('/shopee-fees', [ShopeeFeeConfigController::class, 'update'])->name('shopee-fees.update');
    Route::delete('/shopee-fees/reset', [ShopeeFeeConfigController::class, 'reset'])->name('shopee-fees.reset');

    // Admin Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Documentation Management
    Route::resource('documentations', DocumentationController::class);
    Route::post('documentations/{documentation}/toggle', [DocumentationController::class, 'togglePublished'])->name('documentations.toggle');
    Route::post('documentations/upload-image', [DocumentationController::class, 'uploadImage'])->name('documentations.upload-image');
});

Route::get('/image-tools', function () {
    return view('generator.image-tools');
})->name('image-tools')->middleware('auth');