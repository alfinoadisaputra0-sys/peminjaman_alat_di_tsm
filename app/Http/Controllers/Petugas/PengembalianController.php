<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\TransaksiNotification;

class PengembalianController extends Controller
{
    /**
     * Menampilkan pengajuan pengembalian yang menunggu diproses.
     */
    public function index()
    {
        $pengembalians = Peminjaman::with([
            'user',
            'detailPeminjamans.alat'
        ])
        ->where('status', 'pengajuan_pengembalian')
        ->latest('updated_at')
        ->get();

        return view(
            'petugas.pengembalian.index',
            compact('pengembalians')
        );
    }

    /**
     * Memproses pengembalian alat dan menghitung denda.
     */
    public function proses(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'kondisi_alat' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $peminjaman) {

            $data = Peminjaman::where(
                'id_pinjam',
                $peminjaman->id_pinjam
            )->lockForUpdate()->firstOrFail();

            if ($data->status !== 'pengajuan_pengembalian') {
                throw ValidationException::withMessages([
                    'status' => 'Pengajuan pengembalian ini sudah diproses atau tidak valid.'
                ]);
            }

            if ($data->pengembalians()->exists()) {
                throw ValidationException::withMessages([
                    'pengembalian' => 'Data pengembalian untuk transaksi ini sudah ada.'
                ]);
            }

            $details = $data->detailPeminjamans()->get();

            if ($details->isEmpty()) {
                throw ValidationException::withMessages([
                    'alat' => 'Detail alat peminjaman tidak ditemukan.'
                ]);
            }

            $jumlahPerAlat = $details->groupBy('id_alat')
                ->map(function ($items) {
                    return $items->sum('jumlah');
                });

            $alats = Alat::whereIn(
                'id_alat',
                $jumlahPerAlat->keys()
            )
            ->orderBy('id_alat')
            ->lockForUpdate()
            ->get()
            ->keyBy('id_alat');

            foreach ($jumlahPerAlat as $idAlat => $jumlah) {
                if (!$alats->has($idAlat)) {
                    throw ValidationException::withMessages([
                        'alat' => 'Salah satu alat tidak ditemukan.'
                    ]);
                }
            }

            $tanggalAktual = Carbon::today();

            // tanggal_kembali pada peminjaman adalah batas pengembalian.
            $jatuhTempo = $data->tanggal_kembali
                ? Carbon::parse($data->tanggal_kembali)->startOfDay()
                : null;

            $denda = 0;

            if ($jatuhTempo && $tanggalAktual->greaterThan($jatuhTempo)) {
                $hariTerlambat = (int) $jatuhTempo->diffInDays(
                    $tanggalAktual
                );

                $denda = $hariTerlambat * 1000;
            }

            // Simpan catatan pengembalian aktual.
            Pengembalian::create([
                'id_pinjam' => $data->id_pinjam,
                'tanggal_kembali' => $tanggalAktual->toDateString(),
                'kondisi_alat' => $request->kondisi_alat,
                'denda' => $denda,
                'diterima_oleh' => auth()->user()->name,
            ]);

            // Stok kembali setelah petugas memproses pengembalian.
            foreach ($jumlahPerAlat as $idAlat => $jumlah) {
                $alats->get($idAlat)->increment('stok', $jumlah);
            }

            $data->update([
                'status' => 'dikembalikan',
                'denda' => $denda,
            ]);
        });

        $peminjaman = Peminjaman::with('user')
            ->findOrFail($peminjaman->id_pinjam);

        // Kirim notifikasi kepada User.
        $peminjaman->user->notify(new TransaksiNotification(
            'Pengembalian Selesai',
            'Pengembalian alat lu telah diproses oleh Petugas. Total denda: Rp' .
                number_format((float) $peminjaman->denda, 0, ',', '.') . '.',
            route('user.riwayat'),
            'pengembalian_selesai',
            (int) $peminjaman->id_pinjam
        ));

        // Kirim notifikasi kepada Admin.
        $admin = User::where('role', 'admin')->get();

        foreach ($admin as $penerima) {
            $penerima->notify(new TransaksiNotification(
                'Transaksi Pengembalian Selesai',
                'Petugas telah menyelesaikan proses pengembalian alat.',
                route('admin.dashboard'),
                'pengembalian_selesai',
                (int) $peminjaman->id_pinjam
            ));
        }

        return redirect()
            ->route('petugas.pengembalian.index')
            ->with(
                'success',
                'Pengembalian berhasil diproses. Stok telah dikembalikan dan denda dihitung otomatis.'
            );
    }
}
