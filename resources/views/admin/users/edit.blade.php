
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Edit Akun</h2>
    <p>Perbarui informasi akun User atau Petugas.</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                    User
                </option>
                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>
                    Petugas
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control">
            <small class="text-muted">
                Kosongkan jika tidak ingin mengganti password.
            </small>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation"
                   class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>
@endsection
