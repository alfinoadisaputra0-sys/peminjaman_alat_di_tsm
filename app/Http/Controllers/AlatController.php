<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')->latest()->paginate(10);

        return view('admin.alat.index', compact('alats'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Alat::create($data);

        return redirect()
            ->route('admin.alat.index')
            ->with('success', 'Data alat berhasil ditambahkan.');
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $alat->update($data);

        return redirect()
            ->route('admin.alat.index')
            ->with('success', 'Data alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat)
    {
        if ($alat->detailPeminjamans()->exists()) {
            return redirect()
                ->route('admin.alat.index')
                ->with('error', 'Alat tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $alat->delete();

        return redirect()
            ->route('admin.alat.index')
            ->with('success', 'Data alat berhasil dihapus.');
    }
}
