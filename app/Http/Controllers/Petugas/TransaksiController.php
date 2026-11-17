<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with([
            'user',
            'detailPeminjamans.alat',
            'pengembalians'
        ]);

        // Pencarian berdasarkan nama atau email pengguna.
        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->whereHas('user', function ($userQuery) use ($cari) {
                $userQuery->where('name', 'like', "%{$cari}%")
                    ->orWhere('email', 'like', "%{$cari}%");
            });
        }

        // Filter berdasarkan status transaksi.
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksis = $query
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        // Statistik seluruh transaksi.
        $totalTransaksi = Peminjaman::count();

        $totalMenunggu = Peminjaman::where(
            'status',
            'menunggu'
        )->count();

        $totalDisetujui = Peminjaman::where(
            'status',
            'disetujui'
        )->count();

        $totalDitolak = Peminjaman::where(
            'status',
            'ditolak'
        )->count();

        $totalPengajuanPengembalian = Peminjaman::where(
            'status',
            'pengajuan_pengembalian'
        )->count();

        $totalDikembalikan = Peminjaman::where(
            'status',
            'dikembalikan'
        )->count();

        return view('petugas.transaksi.index', compact(
            'transaksis',
            'totalTransaksi',
            'totalMenunggu',
            'totalDisetujui',
            'totalDitolak',
            'totalPengajuanPengembalian',
            'totalDikembalikan'
        ));
    }
}
