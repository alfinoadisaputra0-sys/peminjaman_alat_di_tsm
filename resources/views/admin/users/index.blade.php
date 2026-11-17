
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Manajemen User</h2>
    <p>Kelola akun User dan Petugas bengkel.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('admin.users.create') }}"
       class="btn btn-primary mb-3">
        + Tambah Akun
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                Admin
                            @elseif($user->role === 'petugas')
                                Petugas
                            @else
                                User
                            @endif
                        </td>
                        <td>
                            @if($user->role !== 'admin')
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                      method="POST"
                                      style="display:inline"
                                      onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">Akun utama</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada data akun.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</div>
@endsection
