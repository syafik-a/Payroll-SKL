<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\AbsensiController as KaryawanAbsensiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KaryawanController as AdminKaryawanController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController; // Nama alias diperbaiki
use App\Http\Controllers\Admin\GajiController as AdminGajiController; // Nama alias diperbaiki

// Auth Routes
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('logout'); // Untuk API pakai sanctum
// Jika web, middleware('auth')

// Jika ini adalah API, Anda mungkin ingin menggunakan Sanctum untuk stateful API
// Atau Passport untuk OAuth2
// Untuk testing sederhana, kita akan menggunakan session based auth jika di web.php, atau sanctum jika di api.php

// Karyawan Routes
Route::middleware(['auth:sanctum', 'karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');
    Route::post('/absensi/masuk', [KaryawanAbsensiController::class, 'presensiMasuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [KaryawanAbsensiController::class, 'presensiPulang'])->name('absensi.pulang');
    Route::get('/absensi/riwayat', [KaryawanAbsensiController::class, 'riwayatAbsensi'])->name('absensi.riwayat');
});

// Admin Routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Karyawan
    Route::apiResource('karyawan', AdminKaryawanController::class); // Menggunakan apiResource untuk API
    // Jika web: Route::resource('karyawan', AdminKaryawanController::class);

    // Absensi Admin
    Route::get('/absensi/rekap', [AdminAbsensiController::class, 'rekapAbsensi'])->name('absensi.rekap');
    Route::get('/absensi/{absensi}/edit', [AdminAbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{absensi}', [AdminAbsensiController::class, 'update'])->name('absensi.update');


    // Gaji Admin
    Route::get('/gaji', [AdminGajiController::class, 'index'])->name('gaji.index');
    Route::post('/gaji/hitung', [AdminGajiController::class, 'prosesHitungGajiBulanan'])->name('gaji.hitung');
    Route::get('/gaji/{gaji_id}/slip', [AdminGajiController::class, 'cetakSlipGaji'])->name('gaji.slip');
});

// Fallback jika route tidak ditemukan (opsional, bagus untuk API)
Route::fallback(function(){
    return response()->json(['message' => 'Not Found.'], 404);
});