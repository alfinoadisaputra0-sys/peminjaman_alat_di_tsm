
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Manajemen Kategori</h2>
    <p>Kelola kategori alat bengkel.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('admin.kategori.create') }}"
       class="btn btn-primary mb-3">
        + Tambah Kategori
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Alat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $kategori)
                    <tr>
                        <td>{{ $kategoris->firstItem() + $loop->index }}</td>
                        <td>{{ $kategori->nama_kategori }}</td>
                        <td>{{ $kategori->alats()->count() }}</td>
                        <td>
                            <a href="{{ route('admin.kategori.edit', $kategori->id_kategori) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}"
                                  method="POST"
                                  style="display:inline"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada kategori alat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $kategoris->links() }}
</div>
@endsection
