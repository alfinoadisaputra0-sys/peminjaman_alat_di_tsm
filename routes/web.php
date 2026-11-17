
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotifikasiController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalianController;
use App\Http\Controllers\Admin\ActivityLogController;

use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalianController;
use App\Http\Controllers\Petugas\LaporanController;
use App\Http\Controllers\Petugas\TransaksiController;

// ==================================================
// HALAMAN UTAMA
// ==================================================

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'petugas' => redirect()->route('petugas.dashboard'),
        'user' => redirect()->route('user.dashboard'),
        default => abort(403),
    };
});

// ==================================================
// AUTHENTICATION
// ==================================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'authenticate'])
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'register'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'store'])
        ->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ==================================================
// NOTIFIKASI
// Semua role yang sudah login dapat mengakses.
// ==================================================

Route::middleware('auth')->prefix('notifikasi')->name('notifikasi.')->group(function () {

    Route::post('/{id}/baca', [
        NotifikasiController::class,
        'baca'
    ])->name('baca');

    Route::post('/baca-semua', [
        NotifikasiController::class,
        'bacaSemua'
    ])->name('baca.semua');

});

// ==================================================
// ADMIN
// Admin hanya mengelola data, bukan persetujuan.
// ==================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        // LOG AKTIVITAS
        Route::get('/aktivitas', [
            ActivityLogController::class,
            'index'
        ])->name('aktivitas.index');

        // CRUD USER
        Route::resource('users', AdminUserController::class)
        ->except(['show']);

        // CRUD KATEGORI
        Route::resource('kategori', AdminKategoriController::class)
        ->except(['show']);

        // CRUD ALAT
        Route::resource('alat', AlatController::class)
        ->except(['show']);

        // CRUD PEMINJAMAN
        Route::resource('peminjaman', AdminPeminjamanController::class);

        // CRUD PENGEMBALIAN
        Route::resource('pengembalian', AdminPengembalianController::class);

    });


// ==================================================
// PETUGAS
// Petugas mengelola persetujuan dan laporan.
// ==================================================

Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [PetugasController::class, 'index'])
            ->name('dashboard');

        // PENGAJUAN PEMINJAMAN
        Route::get('/peminjaman', [
            PetugasPeminjamanController::class,
            'index'
        ])->name('peminjaman.index');

        // SETUJUI PEMINJAMAN
        Route::post('/peminjaman/{peminjaman}/setujui', [
            PetugasPeminjamanController::class,
            'setujui'
        ])->name('peminjaman.setujui');

        // TOLAK PEMINJAMAN
        Route::post('/peminjaman/{peminjaman}/tolak', [
            PetugasPeminjamanController::class,
            'tolak'
        ])->name('peminjaman.tolak');


        // DATA PENGEMBALIAN
        Route::get('/pengembalian', [
            PetugasPengembalianController::class,
            'index'
        ])->name('pengembalian.index');

        // PROSES PENGEMBALIAN
        Route::post('/pengembalian/{peminjaman}/proses', [
            PetugasPengembalianController::class,
            'proses'
        ])->name('pengembalian.proses');


        // LAPORAN
        Route::get('/laporan', [
            LaporanController::class,
            'index'
        ])->name('laporan.index');

        // CETAK LAPORAN
        Route::get('/laporan/cetak', [
            LaporanController::class,
            'cetak'
        ])->name('laporan.cetak');

        Route::get('/transaksi', [TransaksiController::class, 'index'])
        ->name('transaksi.index');
    });


// ==================================================
// USER
// User hanya mengajukan peminjaman.
// ==================================================

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');

        // DAFTAR ALAT
        Route::get('/peminjaman', [
            PeminjamanController::class,
            'index'
        ])->name('peminjaman.index');

        // AJUKAN PEMINJAMAN
        Route::post('/peminjaman/{alat}', [
            PeminjamanController::class,
            'pinjam'
        ])->name('peminjaman.pinjam');

        // RIWAYAT PEMINJAMAN
        Route::get('/riwayat', [
            PeminjamanController::class,
            'riwayat'
        ])->name('riwayat');

        // AJUKAN PENGEMBALIAN
        Route::post('/pengembalian/{peminjaman}', [
            PeminjamanController::class,
            'ajukanPengembalian'
        ])->name('pengembalian.ajukan');

    });
