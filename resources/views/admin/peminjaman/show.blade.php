
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Detail Peminjaman</h2>

    <table class="table table-bordered">
        <tr>
            <th width="200">Kode Peminjaman</th>
            <td>{{ $peminjaman->id_pinjam }}</td>
        </tr>
        <tr>
            <th>Nama Peminjam</th>
            <td>{{ $peminjaman->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $peminjaman->user->email ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Pinjam</th>
            <td>{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($peminjaman->status) }}</td>
        </tr>
        <tr>
            <th>Denda</th>
            <td>Rp{{ number_format($peminjaman->denda, 0, ',', '.') }}</td>
        </tr>
    </table>

    <h4>Alat yang Dipinjam</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Alat</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman->detailPeminjamans as $detail)
                <tr>
                    <td>{{ $detail->alat->nama_alat ?? 'Alat dihapus' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.peminjaman.index') }}"
       class="btn btn-secondary">Kembali</a>
</div>
@endsection
