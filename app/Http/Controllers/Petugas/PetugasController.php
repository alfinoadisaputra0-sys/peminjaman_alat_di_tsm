<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class PetugasController extends Controller
{
    public function index()
    {
        $jumlahUser = User::where('role', 'user')->count();

        $jumlahAlat = Alat::count();

        $jumlahMenunggu = Peminjaman::where(
            'status',
            'menunggu'
        )->count();

        $jumlahDisetujui = Peminjaman::where(
            'status',
            'disetujui'
        )->count();

        $jumlahDitolak = Peminjaman::where(
            'status',
            'ditolak'
        )->count();

        $jumlahDikembalikan = Peminjaman::where(
            'status',
            'dikembalikan'
        )->count();

        $jumlahPengembalian = Pengembalian::count();

        $pengajuanTerbaru = Peminjaman::with([
            'user',
            'detailPeminjamans.alat'
        ])
        ->latest('created_at')
        ->take(5)
        ->get();

        return view('petugas.dashboard', compact(
            'jumlahUser',
            'jumlahAlat',
            'jumlahMenunggu',
            'jumlahDisetujui',
            'jumlahDitolak',
            'jumlahDikembalikan',
            'jumlahPengembalian',
            'pengajuanTerbaru'
        ));
    }
}
