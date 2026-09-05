<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\BeritaController;

// ==========================================
// ROUTES USER (tanpa login)
// ==========================================

// Landing page
Route::get('/', [TesController::class, 'landing'])->name('landing');

// Chatbot
Route::post('/chatbot/send', [AiController::class, 'chatbotSend'])->name('chatbot.send');
Route::post('/chatbot/reset', [AiController::class, 'chatbotReset'])->name('chatbot.reset');

// Biodata
Route::get('/biodata', [TesController::class, 'biodata'])->name('biodata');
Route::post('/biodata/simpan', [TesController::class, 'simpanBiodata'])->name('biodata.simpan');

// Halaman tes 42 soal
Route::get('/tes/{peserta_id}', [TesController::class, 'tes'])->name('tes');
Route::post('/tes/simpan', [TesController::class, 'simpanTes'])->name('tes.simpan');

// Halaman hasil skoring
Route::get('/hasil/{peserta_id}', [TesController::class, 'hasil'])->name('hasil');

// ==========================================
// ROUTES ADMIN (dengan login)
// ==========================================

// Login admin
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Dashboard & peserta (dilindungi middleware auth)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard — hanya grafik & statistik
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Data Peserta — halaman tabel tersendiri
    Route::get('/data-peserta', [AdminController::class, 'peserta'])->name('peserta.list');

    // Detail, update, cetak, hapus peserta
    Route::get('/peserta/{id}', [AdminController::class, 'detail'])->name('peserta.detail');
    Route::put('/peserta/{id}/update-laporan', [AdminController::class, 'updateLaporan'])->name('peserta.update-laporan');
    Route::get('/peserta/{id}/cetak', [AdminController::class, 'cetak'])->name('peserta.cetak');
    Route::delete('/peserta/{id}/hapus', [AdminController::class, 'hapus'])->name('peserta.hapus');

    // Generate AI
    Route::post('/generate-ai/{id}', [AiController::class, 'generate'])->name('generate.ai');

    // Pengaturan Web
    Route::get('/pengaturan', [AdminController::class, 'editPengaturan'])->name('pengaturan.edit');
    Route::put('/pengaturan', [AdminController::class, 'updatePengaturan'])->name('pengaturan.update');

    // CRUD Berita
    Route::resource('berita', BeritaController::class);
});
