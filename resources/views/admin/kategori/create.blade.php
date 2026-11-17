@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Tambah Kategori</h2>
    <p>Masukkan nama kategori alat baru.</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kategori.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_kategori">Nama Kategori</label>
            <input
                type="text"
                id="nama_kategori"
                name="nama_kategori"
                class="form-control"
                value="{{ old('nama_kategori') }}"
                placeholder="Contoh: Alat Mesin"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.kategori.index') }}"
           class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
