<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Notifications\TransaksiNotification;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan seluruh pengajuan peminjaman.
     */
    public function index()
    {
        $peminjamans = Peminjaman::with([
            'user',
            'detailPeminjamans.alat'
        ])
        ->latest('created_at')
        ->get();

        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Menyetujui pengajuan peminjaman.
     * Stok hanya dikurangi setelah pengajuan disetujui.
     */
    public function setujui(Peminjaman $peminjaman)
    {
        DB::transaction(function () use ($peminjaman) {

            $peminjaman = Peminjaman::where(
                'id_pinjam',
                $peminjaman->id_pinjam
            )->lockForUpdate()->firstOrFail();

            if ($peminjaman->status !== 'menunggu') {
                throw ValidationException::withMessages([
                    'status' => 'Pengajuan ini sudah diproses sebelumnya.'
                ]);
            }

            $details = $peminjaman->detailPeminjamans()->get();

            if ($details->isEmpty()) {
                throw ValidationException::withMessages([
                    'alat' => 'Pengajuan ini tidak memiliki detail alat.'
                ]);
            }

            // Jumlahkan apabila alat yang sama tercatat lebih dari sekali.
            $jumlahPerAlat = $details->groupBy('id_alat')
                ->map(function ($items) {
                    return $items->sum('jumlah');
                });

            // Kunci data alat agar stok tidak diproses bersamaan.
            $alats = Alat::whereIn('id_alat', $jumlahPerAlat->keys())
                ->orderBy('id_alat')
                ->lockForUpdate()
                ->get()
                ->keyBy('id_alat');

            // Periksa seluruh stok sebelum mengurangi stok apa pun.
            foreach ($jumlahPerAlat as $idAlat => $jumlah) {
                $alat = $alats->get($idAlat);

                if (!$alat) {
                    throw ValidationException::withMessages([
                        'alat' => 'Salah satu alat dalam pengajuan tidak ditemukan.'
                    ]);
                }

                if ($alat->stok < $jumlah) {
                    throw ValidationException::withMessages([
                        'stok' => 'Stok alat "' . $alat->nama_alat .
                            '" tidak mencukupi. Stok tersedia: ' . $alat->stok
                    ]);
                }
            }

            // Kurangi stok setelah semua alat lolos pemeriksaan.
            foreach ($jumlahPerAlat as $idAlat => $jumlah) {
                $alat = $alats->get($idAlat);
                $alat->decrement('stok', $jumlah);
            }

            // Batas peminjaman adalah 1 hari sejak persetujuan.
            $peminjaman->update([
                'status' => 'disetujui',
                'tanggal_kembali' => now()->addDays(1)->toDateString(),
            ]);
        });

        return redirect()
            ->route('petugas.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil disetujui. Stok alat telah diperbarui.');
    
            $peminjaman = Peminjaman::with('user')
                ->findOrFail($peminjaman->id_pinjam);

            $peminjaman->user->notify(new TransaksiNotification(
                'Peminjaman Disetujui',
                'Pengajuan peminjaman alat lu telah disetujui oleh Petugas.',
                route('user.riwayat'),
                'peminjaman_disetujui',
                (int) $peminjaman->id_pinjam
));
    }


    /**
     * Menolak pengajuan peminjaman.
     * Penolakan tidak mengubah stok.
     */
    public function tolak(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return redirect()
                ->route('petugas.peminjaman.index')
                ->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $peminjaman->update([
            'status' => 'ditolak',
        ]);

        $peminjaman->user->notify(new TransaksiNotification(
            'Peminjaman Ditolak',
            'Maaf, pengajuan peminjaman alat lu ditolak oleh Petugas.',
            route('user.riwayat'),
            'peminjaman_ditolak',
            (int) $peminjaman->id_pinjam
        ));

        return redirect()
            ->route('petugas.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil ditolak.');
    }
}
