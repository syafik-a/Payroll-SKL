<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\AbsensiController as KaryawanAbsensiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KaryawanController as AdminKaryawanController;
use App\Http\Controllers\Admin\AdminAbsensiController; // Sesuaikan dengan nama kelas
use App\Http\Controllers\Admin\AdminGajiController; // Sesuaikan dengan nama kelas

// Route untuk halaman login
Route::get('/', function () {
    return redirect()->route('login.form');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Karyawan Routes
Route::middleware(['auth', 'karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');
    Route::post('/absensi/masuk', [KaryawanAbsensiController::class, 'presensiMasuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [KaryawanAbsensiController::class, 'presensiPulang'])->name('absensi.pulang');
    Route::get('/absensi/riwayat', [KaryawanAbsensiController::class, 'riwayatAbsensi'])->name('absensi.riwayat');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Karyawan
    Route::resource('karyawan', AdminKaryawanController::class);

    // Absensi Admin
    Route::get('/absensi/rekap', [AdminAbsensiController::class, 'rekapAbsensi'])->name('absensi.rekap');
    Route::get('/absensi/{absensi}/edit', [AdminAbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{absensi}', [AdminAbsensiController::class, 'update'])->name('absensi.update');

    // Gaji Admin
    Route::get('/gaji', [AdminGajiController::class, 'index'])->name('gaji.index');
    Route::post('/gaji/hitung', [AdminGajiController::class, 'prosesHitungGajiBulanan'])->name('gaji.hitung');
    Route::get('/gaji/{gaji_id}/slip', [AdminGajiController::class, 'cetakSlipGaji'])->name('gaji.slip');
});