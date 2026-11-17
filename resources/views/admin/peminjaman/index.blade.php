@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Manajemen Peminjaman</h2>
    <p>Admin mengelola data peminjaman tanpa menyetujui atau menolak pengajuan.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('admin.peminjaman.create') }}"
       class="btn btn-primary mb-3">
        + Tambah Peminjaman
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $peminjamans->firstItem() + $loop->index }}</td>
                        <td>{{ $peminjaman->user->name ?? '-' }}</td>
                        <td>{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</td>
                        <td>
                            @foreach($peminjaman->detailPeminjamans as $detail)
                                <div>{{ $detail->alat->nama_alat ?? 'Alat dihapus' }}</div>
                            @endforeach
                        </td>
                        <td>
                            @foreach($peminjaman->detailPeminjamans as $detail)
                                <div>{{ $detail->jumlah }}</div>
                            @endforeach
                        </td>
                        <td>
                            @if($peminjaman->status === 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($peminjaman->status === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($peminjaman->status === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">Dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.peminjaman.show', $peminjaman->id_pinjam) }}"
                               class="btn btn-info btn-sm">Detail</a>

                            @if($peminjaman->status === 'menunggu')
                                <a href="{{ route('admin.peminjaman.edit', $peminjaman->id_pinjam) }}"
                                   class="btn btn-warning btn-sm">Edit</a>
                            @endif

                            <form action="{{ route('admin.peminjaman.destroy', $peminjaman->id_pinjam) }}"
                                  method="POST" style="display:inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada data peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $peminjamans->links() }}
</div>
@endsection
