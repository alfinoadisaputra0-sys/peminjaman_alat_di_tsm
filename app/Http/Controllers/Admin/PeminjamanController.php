<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with([
            'user',
            'detailPeminjamans.alat',
        ])->latest()->paginate(10);

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        $alats = Alat::orderBy('nama_alat')->get();

        return view('admin.peminjaman.create', compact('users', 'alats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'id_alat' => 'required|exists:alats,id_alat',
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = User::findOrFail($data['user_id']);

        if ($user->role !== 'user') {
            return back()->withInput()
                ->withErrors(['user_id' => 'Peminjaman hanya dapat dibuat untuk akun User.']);
        }

        DB::transaction(function () use ($data) {
            $peminjaman = Peminjaman::create([
                'user_id' => $data['user_id'],
                'tanggal_pinjam' => $data['tanggal_pinjam'],
                'tanggal_kembali' => null,
                'status' => 'menunggu',
                'denda' => 0,
            ]);

            DetailPeminjaman::create([
                'id_pinjam' => $peminjaman->id_pinjam,
                'id_alat' => $data['id_alat'],
                'jumlah' => $data['jumlah'],
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load([
            'user',
            'detailPeminjamans.alat',
            'pengembalians',
        ]);

        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return redirect()
                ->route('admin.peminjaman.index')
                ->with('error', 'Hanya peminjaman berstatus menunggu yang dapat diedit.');
        }

        $peminjaman->load('detailPeminjamans');

        $users = User::where('role', 'user')->orderBy('name')->get();
        $alats = Alat::orderBy('nama_alat')->get();

        return view('admin.peminjaman.edit', compact(
            'peminjaman',
            'users',
            'alats'
        ));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return redirect()
                ->route('admin.peminjaman.index')
                ->with('error', 'Peminjaman ini tidak dapat diedit.');
        }

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'id_alat' => 'required|exists:alats,id_alat',
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = User::findOrFail($data['user_id']);

        if ($user->role !== 'user') {
            return back()->withInput()
                ->withErrors(['user_id' => 'Peminjaman hanya dapat dimiliki akun User.']);
        }

        DB::transaction(function () use ($data, $peminjaman) {
            $peminjamanTerkunci = Peminjaman::where(
                'id_pinjam',
                $peminjaman->id_pinjam
            )->lockForUpdate()->firstOrFail();

            if ($peminjamanTerkunci->status !== 'menunggu') {
                throw new \RuntimeException(
                    'Status peminjaman sudah berubah dan tidak dapat diedit.'
                );
            }

            $peminjamanTerkunci->update([
                'user_id' => $data['user_id'],
                'tanggal_pinjam' => $data['tanggal_pinjam'],
            ]);

            $peminjamanTerkunci->detailPeminjamans()->delete();

            DetailPeminjaman::create([
                'id_pinjam' => $peminjamanTerkunci->id_pinjam,
                'id_alat' => $data['id_alat'],
                'jumlah' => $data['jumlah'],
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        DB::transaction(function () use ($peminjaman) {
            $data = Peminjaman::where(
                'id_pinjam',
                $peminjaman->id_pinjam
            )->lockForUpdate()->firstOrFail();

            // Jika sudah disetujui, kembalikan stok sebelum menghapus.
            if ($data->status === 'disetujui') {
                $details = $data->detailPeminjamans;

                foreach ($details as $detail) {
                    $alat = Alat::where('id_alat', $detail->id_alat)
                        ->lockForUpdate()
                        ->first();

                    if ($alat) {
                        $alat->increment('stok', $detail->jumlah);
                    }
                }
            }

            $data->delete();
        });

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
