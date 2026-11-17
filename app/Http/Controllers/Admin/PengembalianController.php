<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.detailPeminjamans.alat',
        ])->latest()->paginate(10);

        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        // Admin hanya mencatat peminjaman yang sudah selesai diproses Petugas.
        $peminjamans = Peminjaman::with('user')
            ->where('status', 'dikembalikan')
            ->whereDoesntHave('pengembalians')
            ->orderByDesc('tanggal_kembali')
            ->get();

        return view('admin.pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_pinjam' => 'required|exists:peminjamen,id_pinjam',
            'tanggal_kembali' => 'required|date',
            'kondisi_alat' => 'required|string|max:255',
            'denda' => 'required|numeric|min:0',
            'diterima_oleh' => 'required|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($data['id_pinjam']);

        if ($peminjaman->status !== 'dikembalikan') {
            return back()->withInput()->withErrors([
                'id_pinjam' => 'Catatan hanya dapat dibuat untuk peminjaman yang sudah dikembalikan oleh Petugas.',
            ]);
        }

        if ($peminjaman->pengembalians()->exists()) {
            return back()->withInput()->withErrors([
                'id_pinjam' => 'Catatan pengembalian untuk peminjaman ini sudah tersedia.',
            ]);
        }

        // Hanya membuat catatan. Tidak mengubah status atau stok alat.
        Pengembalian::create($data);

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Catatan pengembalian berhasil ditambahkan.');
    }

    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load([
            'peminjaman.user',
            'peminjaman.detailPeminjamans.alat',
        ]);

        return view('admin.pengembalian.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian)
    {
        $pengembalian->load('peminjaman.user');

        return view('admin.pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $data = $request->validate([
            'tanggal_kembali' => 'required|date',
            'kondisi_alat' => 'required|string|max:255',
            'denda' => 'required|numeric|min:0',
            'diterima_oleh' => 'required|string|max:255',
        ]);

        // Perubahan ini hanya mengubah catatan pengembalian.
        // Tidak mengubah stok dan status peminjaman.
        $pengembalian->update($data);

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Catatan pengembalian berhasil diperbarui.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        // Hapus catatan saja. Status peminjaman dan stok tidak diubah.
        $pengembalian->delete();

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Catatan pengembalian berhasil dihapus.');
    }
}
