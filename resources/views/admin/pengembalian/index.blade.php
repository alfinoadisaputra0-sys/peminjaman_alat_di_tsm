
@extends('layouts.admin')

@section('title', 'Data Pengembalian')

@section('content')
<div class="container-fluid">

    <h2 class="mb-2">Data Pengembalian</h2>

    <p class="text-muted">
        Daftar catatan pengembalian alat bengkel.
    </p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('admin.pengembalian.create') }}"
       class="btn btn-primary mb-3">
        + Tambah Pengembalian
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>ID Peminjaman</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Kondisi Alat</th>
                    <th>Denda</th>
                    <th>Diterima Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengembalians as $pengembalian)
                    <tr>
                        <td>
                            {{ $pengembalians->firstItem() + $loop->index }}
                        </td>

                        <td>{{ $pengembalian->id_pinjam }}</td>

                        <td>
                            {{ $pengembalian->peminjaman->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ $pengembalian->tanggal_kembali->format('d-m-Y') }}
                        </td>

                        <td>{{ $pengembalian->kondisi_alat }}</td>

                        <td>
                            Rp{{ number_format((float) $pengembalian->denda, 0, ',', '.') }}
                        </td>

                        <td>{{ $pengembalian->diterima_oleh }}</td>

                        <td>
                            <a href="{{ route('admin.pengembalian.show', $pengembalian->id_kembali) }}"
                               class="btn btn-info btn-sm">
                                Detail
                            </a>

                            <a href="{{ route('admin.pengembalian.edit', $pengembalian->id_kembali) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.pengembalian.destroy', $pengembalian->id_kembali) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            Belum ada data pengembalian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $pengembalians->links() }}

</div>
@endsection
