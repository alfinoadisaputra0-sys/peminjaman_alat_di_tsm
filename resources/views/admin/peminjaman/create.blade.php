
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Tambah Peminjaman</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.peminjaman.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Peminjam</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Peminjaman</label>
            <input type="date" name="tanggal_pinjam"
                   class="form-control"
                   value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label>Nama Alat</label>
            <select name="id_alat" class="form-control" required>
                <option value="">-- Pilih Alat --</option>
                @foreach($alats as $alat)
                    <option value="{{ $alat->id_alat }}"
                        {{ old('id_alat') == $alat->id_alat ? 'selected' : '' }}>
                        {{ $alat->nama_alat }} (Stok: {{ $alat->stok }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" min="1"
                   class="form-control" value="{{ old('jumlah', 1) }}" required>
        </div>

        <div class="alert alert-info">
            Peminjaman yang ditambahkan akan berstatus Menunggu.
            Stok belum dikurangi sampai Petugas menyetujui pengajuan.
        </div>

        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="{{ route('admin.peminjaman.index') }}"
           class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
