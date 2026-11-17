<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\TransaksiNotification;

class PeminjamanController extends Controller
{
    // DAFTAR ALAT
    public function index()
    {
        $alats = Alat::with('kategori')
            ->orderBy('nama_alat')
            ->get();

        return view('user.peminjaman.index', compact('alats'));
    }

    // PROSES PENGAJUAN PEMINJAMAN
    public function pinjam(Request $request, Alat $alat)
    {
        $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        try {

            $idPinjam = null;
                DB::transaction(function () use ($request, $alat, &$idPinjam) {

                $alatTerkunci = Alat::where(
                    'id_alat',
                    $alat->id_alat
                )->lockForUpdate()->firstOrFail();

                $jumlah = (int) $request->jumlah;

                if ($alatTerkunci->stok < $jumlah) {
                    throw new \RuntimeException(
                        'Stok alat tidak mencukupi.'
                    );
                }

                $peminjaman = Peminjaman::create([
                    'user_id' => auth()->id(),
                    'tanggal_pinjam' => now()->toDateString(),
                    'tanggal_kembali' => null,
                    'status' => 'menunggu',
                    'denda' => 0,
                ]);

                $idPinjam = $peminjaman->id_pinjam;

                DetailPeminjaman::create([
                    'id_pinjam' => $peminjaman->id_pinjam,
                    'id_alat' => $alatTerkunci->id_alat,
                    'jumlah' => $jumlah,
                ]);

                // Stok TIDAK dikurangi di sini.
                // Stok dikurangi ketika Petugas menyetujui.
            });
            
            $petugasDanAdmin = User::whereIn('role', ['petugas', 'admin'])->get();

                foreach ($petugasDanAdmin as $penerima) {
                    $penerima->notify(new TransaksiNotification(
                        'Pengajuan Peminjaman Baru',
                        'Ada pengajuan peminjaman alat baru yang perlu diperiksa.',
                        $penerima->role === 'admin'
                            ? route('admin.dashboard')
                            : route('petugas.peminjaman.index'),
                        'peminjaman_baru',
                        (int) $idPinjam
                    ));
                }

            return redirect()
                ->route('user.riwayat')
                ->with('success', 'Pengajuan peminjaman berhasil dikirim. Silakan tunggu persetujuan Petugas.');

        } catch (\RuntimeException $e) {

            return back()->with('error', $e->getMessage());
        }
    }

    // RIWAYAT PEMINJAMAN
    public function riwayat()
    {
        $peminjamans = Peminjaman::with([
            'detailPeminjamans.alat',
            'pengembalians'
        ])
        ->where('user_id', auth()->id())
        ->orderByDesc('tanggal_pinjam')
        ->get();

        return view('user.riwayat', compact('peminjamans'));
    }

    // PENGAJUAN PENGEMBALIAN
    public function ajukanPengembalian(
        Peminjaman $peminjaman
    ) {
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        if ($peminjaman->status !== 'disetujui') {
            return back()->with(
                'error',
                'Peminjaman tidak dapat diajukan untuk pengembalian.'
            );
        }

        $peminjaman->update([
            'status' => 'pengajuan_pengembalian',
        ]);

        $petugas = User::where('role', 'petugas')->get();

        foreach ($petugas as $penerima) {
            $penerima->notify(new TransaksiNotification(
                'Pengajuan Pengembalian',
                'Ada user yang mengajukan pengembalian alat.',
                route('petugas.pengembalian.index'),
                'pengajuan_pengembalian',
                (int) $peminjaman->id_pinjam
            ));
        }

        return back()->with(
            'success',
            'Pengajuan pengembalian berhasil dikirim.'
        );
    }
}
