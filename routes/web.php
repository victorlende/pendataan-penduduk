<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\SuratKeteranganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DusunController;
use App\Http\Controllers\KkController;

Auth::routes();

Route::get('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Shared Laporan Routes
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan/penduduk-dusun', [LaporanController::class, 'pendudukPerDusun'])
        ->name('laporan.pendudukDusun');

    Route::get('/laporan/penduduk-kk', [LaporanController::class, 'pendudukPerKK'])
        ->name('laporan.pendudukKK');

        Route::get('/laporan/rekap', [LaporanController::class, 'rekapPenduduk'])
            ->name('laporan.rekap');

        Route::get('/surat/{id}/print', [App\Http\Controllers\SuratPrintController::class, 'print'])
            ->name('surat.print');

        // Letter Templates Management
        Route::get('/surat/templates', [App\Http\Controllers\LetterTemplateController::class, 'index'])
            ->name('letter-templates.index');
        Route::get('/surat/templates/{id}/edit', [App\Http\Controllers\LetterTemplateController::class, 'edit'])
            ->name('letter-templates.edit');
        Route::put('/surat/templates/{id}', [App\Http\Controllers\LetterTemplateController::class, 'update'])
            ->name('letter-templates.update');

    Route::middleware(['role:admin'])->group(function () {

        Route::resource('dusun', DusunController::class);
        Route::resource('kk', KkController::class);
        Route::resource('petugas', \App\Http\Controllers\PetugasController::class);
        Route::put('petugas/{id}/assign', [\App\Http\Controllers\PetugasController::class, 'assignDusun'])->name('petugas.assignDusun');
        Route::resource('mutasi', \App\Http\Controllers\MutasiController::class);

        Route::get('penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
        Route::post('penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
        Route::get('penduduk/{penduduk}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit');
        Route::put('penduduk/{penduduk}', [PendudukController::class, 'update'])->name('penduduk.update');
        Route::delete('penduduk/{penduduk}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');
        Route::get('/penduduk', [PendudukController::class, 'index'])
            ->name('penduduk.index');

        Route::get('/penduduk/{id}', [PendudukController::class, 'show'])
            ->name('penduduk.show');
        
        Route::post('/penduduk/{id}/verify', [PendudukController::class, 'verify'])
            ->name('penduduk.verify');
        Route::get('/surat', [SuratKeteranganController::class, 'index'])
            ->name('surat.index');

        Route::post('/surat/{id}/status', [SuratKeteranganController::class, 'updateStatus'])
            ->name('surat.updateStatus');



                Route::get('/notifikasi', [NotificationController::class, 'index'])
        ->name('notifications.index');
        
        Route::get('/notifikasi/telegram-sync', [NotificationController::class, 'syncTelegram'])->name('notifications.syncTelegram');
        Route::post('/notifikasi/telegram-update', [NotificationController::class, 'updateTelegramId'])->name('notifications.updateTelegramId');
        Route::get('/notifikasi/telegram-admin-setup', [NotificationController::class, 'adminTelegramSetup'])->name('notifications.adminTelegramSetup');

        Route::get('/verifikasi', [App\Http\Controllers\VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::post('/verifikasi/{id}/approve', [App\Http\Controllers\VerifikasiController::class, 'approve'])->name('verifikasi.approve');
        Route::post('/verifikasi/{id}/reject', [App\Http\Controllers\VerifikasiController::class, 'reject'])->name('verifikasi.reject');

        Route::post('/notifikasi/{id}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');

    });


    Route::get('/verifikasi-akun', function () {
        return view('auth.verify-status');
    })->name('verification.notice');

    Route::middleware(['role:masyarakat', 'user.active'])->group(function () {
        Route::get('/surat-saya', [SuratKeteranganController::class, 'mySurat'])->name('surat.my');
        Route::post('/surat-saya', [SuratKeteranganController::class, 'storeRequest'])->name('surat.storeRequest');

        // Telegram setup untuk masyarakat
        Route::get('/telegram-setup', [NotificationController::class, 'userTelegramSetup'])->name('notifications.userTelegramSetup');
        Route::post('/telegram-setup', [NotificationController::class, 'saveUserTelegramId'])->name('notifications.saveUserTelegramId');
    });
});

Route::get('/home', function() {
    if (auth()->check() && auth()->user()->role == 'masyarakat') {
        return redirect()->route('surat.my');
    }
    return redirect()->route('dashboard');
})->name('home');
