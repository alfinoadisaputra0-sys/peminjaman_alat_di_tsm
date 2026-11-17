<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class AdminController extends Controller
{
    public function index()
    {
        $jumlahUser = User::where('role', 'user')->count();
        $jumlahPetugas = User::where('role', 'petugas')->count();
        $jumlahAlat = Alat::count();
        $jumlahKategori = Kategori::count();

        $jumlahPeminjaman = Peminjaman::count();

        $peminjamanMenunggu = Peminjaman::where(
            'status',
            'menunggu'
        )->count();

        $peminjamanDisetujui = Peminjaman::where(
            'status',
            'disetujui'
        )->count();

        $jumlahPengembalian = Pengembalian::count();

        return view('admin.dashboard', compact(
            'jumlahUser',
            'jumlahPetugas',
            'jumlahAlat',
            'jumlahKategori',
            'jumlahPeminjaman',
            'peminjamanMenunggu',
            'peminjamanDisetujui',
            'jumlahPengembalian'
        ));
    }
}
