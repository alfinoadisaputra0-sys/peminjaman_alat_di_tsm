
@extends('layouts.admin')

@section('title', 'Tambah Pengembalian')

@section('content')
<div class="container-fluid">

    <h2>Tambah Catatan Pengembalian</h2>
    <p class="text-muted">
        Pilih peminjaman yang sudah diselesaikan oleh Petugas.
    </p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($peminjamans->isEmpty())
        <div class="alert alert-warning">
            Belum ada peminjaman yang selesai diproses Petugas dan belum memiliki catatan pengembalian.
        </div>
    @endif

    <form action="{{ route('admin.pengembalian.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Peminjaman</label>

            <select name="id_pinjam" class="form-select" required>
                <option value="">-- Pilih Peminjaman --</option>

                @foreach($peminjamans as $peminjaman)
                    <option value="{{ $peminjaman->id_pinjam }}"
                        {{ old('id_pinjam') == $peminjaman->id_pinjam ? 'selected' : '' }}>
                        Peminjaman #{{ $peminjaman->id_pinjam }}
                        - {{ $peminjaman->user->name ?? '-' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Kembali</label>
            <input type="date"
                   name="tanggal_kembali"
                   class="form-control"
                   value="{{ old('tanggal_kembali', date('Y-m-d')) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kondisi Alat</label>
            <select name="kondisi_alat" class="form-select" required>
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik" {{ old('kondisi_alat') == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak Ringan" {{ old('kondisi_alat') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="Rusak Berat" {{ old('kondisi_alat') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Denda (Rp)</label>
            <input type="number"
                   name="denda"
                   class="form-control"
                   min="0"
                   step="0.01"
                   value="{{ old('denda', 0) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Diterima Oleh</label>
            <input type="text"
                   name="diterima_oleh"
                   class="form-control"
                   value="{{ old('diterima_oleh') }}"
                   required>
        </div>

        <div class="alert alert-info">
            Form ini hanya untuk pencatatan administratif. Proses penerimaan alat dan penambahan stok dilakukan oleh Petugas.
        </div>

        <button type="submit"
                class="btn btn-primary"
                {{ $peminjamans->isEmpty() ? 'disabled' : '' }}>
            Simpan
        </button>

        <a href="{{ route('admin.pengembalian.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>
    </form>

</div>
@endsection
