<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PsbSettingController;


/*
|--------------------------------------------------------------------------
| Web Routes - Pondok Pesantren Nurussyam
|--------------------------------------------------------------------------
*/

// --- Public Website Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/artikel/{slug}', [HomeController::class, 'article'])->name('article.show');
Route::get('/kategori/{category}', [HomeController::class, 'index'])->name('category.show');
Route::get('/pendaftaran', [HomeController::class, 'pendaftaran'])->name('pendaftaran');
Route::get('/pendaftaran/informasi', [HomeController::class, 'psbInfo'])->name('pendaftaran.info');
Route::get('/pendaftaran/syarat-berkas', [HomeController::class, 'psbSyarat'])->name('pendaftaran.syarat');
Route::get('/pendaftaran/cek', [HomeController::class, 'pendaftaran'])->name('pendaftaran.cek');
Route::get('/pendaftaran/bukti/{no_pendaftaran}', [HomeController::class, 'printSlipPublic'])->name('pendaftaran.slip');
Route::post('/pendaftaran', [HomeController::class, 'storeRegistration'])->name('pendaftaran.store');
Route::get('/kontak', [HomeController::class, 'page'])->defaults('slug', 'kontak')->name('kontak');
Route::get('/menu/{slug}', [HomeController::class, 'page'])->name('page.show');

// --- LAZISWAF & Donasi Public Routes ---
Route::get('/laziswaf', [HomeController::class, 'laziswaf'])->name('laziswaf.index');
Route::get('/donasi/masjid', [HomeController::class, 'donasiMasjid'])->name('donasi.masjid');
Route::get('/donasi/pondok', [HomeController::class, 'donasiPondok'])->name('donasi.pondok');
Route::post('/donasi/kirim', [HomeController::class, 'storePublicDonation'])->name('donasi.store');

// --- Admin Authentication Routes ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');

// --- Forgot & Reset Password Routes (Verifikasi Kode via Email) ---
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::get('/admin/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [AuthController::class, 'sendResetCode'])->name('admin.password.email');
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::get('/admin/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('admin.password.reset');
Route::post('/admin/reset-password', [AuthController::class, 'resetPassword'])->name('admin.password.update');

// --- Protected Admin Dashboard Routes ---
Route::prefix('admin')->middleware(['auth', 'auto.logout'])->name('admin.')->group(function () {
    // Logout (All roles)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/ping', fn() => response()->json(['status' => 'active', 'time' => time()]))->name('ping');

    // Dashboard Overview (Admin & Staff, Penulis redirects to articles)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile & Password (All roles)
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // --- News & Articles Management (Admin, Staff, Penulis) ---
    Route::middleware('role:admin,staff,penulis')->group(function () {
        Route::resource('articles', ArticleController::class)->except(['show']);
        Route::patch('articles/{article}/toggle-publish', [ArticleController::class, 'togglePublish'])->name('articles.toggle-publish');
        Route::patch('articles/{article}/toggle-featured', [ArticleController::class, 'toggleFeatured'])->name('articles.toggle-featured');

        // --- Gallery Activities Management ---
        Route::resource('galleries', GalleryController::class)->except(['show']);
        Route::patch('galleries/{gallery}/toggle-publish', [GalleryController::class, 'togglePublish'])->name('galleries.toggle-publish');
    });

    // --- Category Management (Admin & Staff) ---
    Route::middleware('role:admin,staff')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
    });

    // --- Santri PSB Registration Management ---
    // Staff & Admin: view, update notes/status, and print slip
    Route::middleware('role:admin,staff')->group(function () {
        Route::get('registrations/export/excel', [RegistrationController::class, 'exportExcel'])->name('registrations.export.excel');
        Route::get('registrations/export/print', [RegistrationController::class, 'printRekap'])->name('registrations.export.print');
        Route::get('registrations', [RegistrationController::class, 'index'])->name('registrations.index');
        Route::get('registrations/{registration}', [RegistrationController::class, 'show'])->name('registrations.show');
        Route::put('registrations/{registration}/status', [RegistrationController::class, 'updateStatus'])->name('registrations.update-status');
        Route::get('registrations/{registration}/print', [RegistrationController::class, 'printSlip'])->name('registrations.print');

        // Pengaturan Informasi PSB & Periode Gelombang (Admin & Staff)
        Route::get('psb-settings', [PsbSettingController::class, 'index'])->name('psb.settings');
        Route::post('psb-settings', [PsbSettingController::class, 'update'])->name('psb.settings.update');
        Route::post('psb-settings/toggle', [PsbSettingController::class, 'toggle'])->name('psb.settings.toggle');
    });


    // Staff Only: Verification of Documents
    Route::middleware('role:staff')->group(function () {
        Route::patch('registrations/{registration}/verify', [RegistrationController::class, 'verify'])->name('registrations.verify');
    });

    // Admin Only: Approval & Deletion of Registrations
    Route::middleware('role:admin')->group(function () {
        Route::patch('registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
        Route::delete('registrations/{registration}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');
    });

    // --- Super Admin Exclusive Routes ---
    Route::middleware('role:admin')->group(function () {
        // Data Santri Aktif (Accepted Students Directory)
        Route::get('students/export/excel', [StudentController::class, 'exportExcel'])->name('students.export.excel');
        Route::get('students/export/print', [StudentController::class, 'printRekap'])->name('students.export.print');
        Route::get('students', [StudentController::class, 'index'])->name('students.index');
        Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('students', [StudentController::class, 'store'])->name('students.store');
        Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::get('students/{student}/card', [StudentController::class, 'printCard'])->name('students.card');

        // Laziswaf & Donations Management
        Route::get('donations', [DonationController::class, 'index'])->name('donations.index');
        Route::post('donations', [DonationController::class, 'store'])->name('donations.store');
        Route::put('donations/{donation}/verify', [DonationController::class, 'verify'])->name('donations.verify');
        Route::delete('donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');

        // Site Settings & Social Media
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::post('settings/social', [SettingController::class, 'updateSocial'])->name('settings.social');
        Route::post('settings/social/sync', [SettingController::class, 'syncSocial'])->name('settings.social.sync');

        // User Management & Access Control
        Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);

        // Role Access & Permissions Management
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->except(['show', 'create', 'edit']);

        // System Activity Logs & Audit History
        Route::get('activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::post('activity-logs/clear-old', [\App\Http\Controllers\Admin\ActivityLogController::class, 'clearOld'])->name('activity-logs.clear-old');
    });
});


