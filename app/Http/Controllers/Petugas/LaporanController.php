<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Query laporan yang digunakan oleh halaman laporan
     * dan halaman cetak.
     */
    private function queryLaporan(Request $request)
    {
        $query = Peminjaman::with([
            'user',
            'detailPeminjamans.alat',
            'pengembalians'
        ]);

        // Filter tanggal mulai
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'tanggal_pinjam',
                '>=',
                $request->tanggal_mulai
            );
        }

        // Filter tanggal akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate(
                'tanggal_pinjam',
                '<=',
                $request->tanggal_akhir
            );
        }

        // Filter status peminjaman
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nama atau email pengguna
        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->whereHas('user', function ($subQuery) use ($cari) {
                $subQuery->where('name', 'like', "%{$cari}%")
                    ->orWhere('email', 'like', "%{$cari}%");
            });
        }

        return $query->orderBy('tanggal_pinjam', 'desc');
    }

    /**
     * Menampilkan halaman laporan.
     */
    public function index(Request $request)
    {
        $laporans = $this->queryLaporan($request)
            ->paginate(10)
            ->withQueryString();

        return view('petugas.laporan.index', compact('laporans'));
    }

    /**
     * Menampilkan halaman khusus untuk mencetak laporan.
     */
    public function cetak(Request $request)
    {
        $laporans = $this->queryLaporan($request)->get();

        return view('petugas.laporan.cetak', compact('laporans'));
    }
}