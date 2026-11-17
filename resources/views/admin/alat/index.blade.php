
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Manajemen Alat</h2>
    <p>Kelola data dan stok alat bengkel TSM.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('admin.alat.create') }}"
       class="btn btn-primary mb-3">
        + Tambah Alat
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Kondisi</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($alats as $alat)
                    <tr>
                        <td>{{ $alats->firstItem() + $loop->index }}</td>
                        <td>{{ $alat->nama_alat }}</td>
                        <td>{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $alat->stok }}</td>
                        <td>{{ $alat->kondisi }}</td>
                        <td>{{ $alat->lokasi ?? '-' }}</td>
                        <td>{{ $alat->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.alat.edit', $alat->id_alat) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.alat.destroy', $alat->id_alat) }}"
                                  method="POST"
                                  style="display:inline"
                                  onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
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
                        <td colspan="8" class="text-center">
                            Belum ada data alat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $alats->links() }}
</div>
@endsection
