
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Edit Data Alat</h2>
    <p>Perbarui informasi alat bengkel.</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.alat.update', $alat->id_alat) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_alat">Nama Alat</label>
            <input type="text" id="nama_alat" name="nama_alat"
                   class="form-control"
                   value="{{ old('nama_alat', $alat->nama_alat) }}"
                   required>
        </div>

        <div class="mb-3">
            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" name="kategori_id"
                    class="form-control" required>
                <option value="">-- Pilih Kategori --</option>

                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}"
                        {{ old('kategori_id', $alat->kategori_id) == $kategori->id_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok"
                   class="form-control" min="0"
                   value="{{ old('stok', $alat->stok) }}"
                   required>
        </div>

        <div class="mb-3">
            <label for="kondisi">Kondisi Alat</label>
            <select id="kondisi" name="kondisi" class="form-control" required>
                <option value="Baik" {{ old('kondisi', $alat->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak Ringan" {{ old('kondisi', $alat->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="Rusak Berat" {{ old('kondisi', $alat->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="lokasi">Lokasi Penyimpanan</label>
            <input type="text" id="lokasi" name="lokasi"
                   class="form-control"
                   placeholder="Contoh: Lemari A, Rak B, Gudang"
                   value="{{ old('lokasi', $alat->lokasi) }}">
        </div>

        <div class="mb-3">
            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" name="keterangan"
                      class="form-control" rows="4">{{ old('keterangan', $alat->keterangan) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>

        <a href="{{ route('admin.alat.index') }}"
           class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
