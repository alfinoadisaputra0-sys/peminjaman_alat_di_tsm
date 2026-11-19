<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\Pengembalian;
use App\Models\User;
use App\Notifications\TransaksiNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /**
     * Menghitung denda Rp1.000 per hari.
     */
    private function hitungDenda($tanggalBatas, $tanggalPemeriksaan)
    {
        if (!$tanggalBatas) {
            return [
                'hari_terlambat' => 0,
                'denda' => 0,
            ];
        }

        $batas = Carbon::parse(
            $tanggalBatas,
            'Asia/Jakarta'
        )->startOfDay();

        $pemeriksaan = Carbon::parse(
            $tanggalPemeriksaan,
            'Asia/Jakarta'
        )->startOfDay();

        if ($pemeriksaan->lessThanOrEqualTo($batas)) {
            return [
                'hari_terlambat' => 0,
                'denda' => 0,
            ];
        }

        $hariTerlambat = (int) $batas->diffInDays($pemeriksaan);

        return [
            'hari_terlambat' => $hariTerlambat,
            'denda' => $hariTerlambat * 1000,
        ];
    }

    /**
     * Menampilkan pengajuan pengembalian.
     * Petugas dapat memilih tanggal untuk simulasi denda.
     */
    public function index(Request $request)
    {
        $request->validate([
            'tanggal_cek' => 'nullable|date_format:Y-m-d',
        ]);

        // Jika petugas tidak memilih tanggal,
        // gunakan tanggal hari ini berdasarkan WIB.
        $tanggalCek = $request->input(
            'tanggal_cek',
            Carbon::now('Asia/Jakarta')->toDateString()
        );

        $pengembalians = Peminjaman::with([
            'user',
            'detailPeminjamans.alat'
        ])
            ->where('status', 'pengajuan_pengembalian')
            ->latest('updated_at')
            ->get();

        // Hitung estimasi denda berdasarkan tanggal pilihan petugas.
        foreach ($pengembalians as $peminjaman) {

            $hasil = $this->hitungDenda(
                $peminjaman->tanggal_kembali,
                $tanggalCek
            );

            $peminjaman->hari_terlambat =
                $hasil['hari_terlambat'];

            $peminjaman->estimasi_denda =
                $hasil['denda'];
        }

        return view(
            'petugas.pengembalian.index',
            compact('pengembalians', 'tanggalCek')
        );
    }

    /**
     * Memproses pengembalian sebenarnya.
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

            // Tanggal sebenarnya, bukan tanggal simulasi.
            $tanggalAktual = Carbon::now('Asia/Jakarta')
                ->startOfDay();

            // Hitung denda berdasarkan tanggal aktual WIB.
            $hasilDenda = $this->hitungDenda(
                $data->tanggal_kembali,
                $tanggalAktual->toDateString()
            );

            $denda = $hasilDenda['denda'];

            // Simpan data pengembalian.
            Pengembalian::create([
                'id_pinjam' => $data->id_pinjam,
                'tanggal_kembali' => $tanggalAktual->toDateString(),
                'kondisi_alat' => $request->kondisi_alat,
                'denda' => $denda,
                'diterima_oleh' => auth()->user()->name,
            ]);

            // Kembalikan stok alat.
            foreach ($jumlahPerAlat as $idAlat => $jumlah) {
                $alats->get($idAlat)->increment('stok', $jumlah);
            }

            // Perbarui status dan denda peminjaman.
            $data->update([
                'status' => 'dikembalikan',
                'denda' => $denda,
            ]);
        });

        $peminjaman = Peminjaman::with('user')
            ->findOrFail($peminjaman->id_pinjam);

        // Notifikasi kepada pengguna.
        $peminjaman->user->notify(new TransaksiNotification(
            'Pengembalian Selesai',
            'Pengembalian alat telah diproses oleh Petugas. Total denda: Rp' .
                number_format((float) $peminjaman->denda, 0, ',', '.') . '.',
            route('user.riwayat'),
            'pengembalian_selesai',
            (int) $peminjaman->id_pinjam
        ));

        // Notifikasi kepada Admin.
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
                'Pengembalian berhasil diproses. Denda telah dihitung berdasarkan tanggal aktual WIB.'
            );
    }
}
