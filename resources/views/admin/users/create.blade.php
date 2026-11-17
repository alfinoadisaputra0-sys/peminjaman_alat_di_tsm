
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Tambah Akun</h2>
    <p>Tambahkan akun User atau Petugas baru.</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                    User
                </option>
                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>
                    Petugas
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>
@endsection
