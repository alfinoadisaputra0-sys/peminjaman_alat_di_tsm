
@extends('layouts.admin')

@section('title', 'Edit Pengembalian')

@section('content')
<div class="container-fluid">

    <h2>Edit Catatan Pengembalian</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="alert alert-info">
        Peminjaman #{{ $pengembalian->id_pinjam }}
        - {{ $pengembalian->peminjaman->user->name ?? '-' }}
    </div>

    <form action="{{ route('admin.pengembalian.update', $pengembalian->id_kembali) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tanggal Kembali</label>
            <input type="date"
                   name="tanggal_kembali"
                   class="form-control"
                   value="{{ old('tanggal_kembali', $pengembalian->tanggal_kembali->format('Y-m-d')) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kondisi Alat</label>
            <select name="kondisi_alat" class="form-select" required>
                @foreach(['Baik', 'Rusak Ringan', 'Rusak Berat'] as $kondisi)
                    <option value="{{ $kondisi }}"
                        {{ old('kondisi_alat', $pengembalian->kondisi_alat) == $kondisi ? 'selected' : '' }}>
                        {{ $kondisi }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Denda (Rp)</label>
            <input type="number"
                   name="denda"
                   class="form-control"
                   min="0"
                   step="0.01"
                   value="{{ old('denda', $pengembalian->denda) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Diterima Oleh</label>
            <input type="text"
                   name="diterima_oleh"
                   class="form-control"
                   value="{{ old('diterima_oleh', $pengembalian->diterima_oleh) }}"
                   required>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>

        <a href="{{ route('admin.pengembalian.index') }}"
           class="btn btn-secondary">Kembali</a>
    </form>

</div>
@endsection
