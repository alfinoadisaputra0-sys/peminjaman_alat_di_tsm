
@extends('layouts.admin')

@section('title', 'Detail Pengembalian')

@section('content')
<div class="container-fluid">

    <h2>Detail Pengembalian</h2>

    <table class="table table-bordered">
        <tr>
            <th width="220">ID Pengembalian</th>
            <td>{{ $pengembalian->id_kembali }}</td>
        </tr>

        <tr>
            <th>ID Peminjaman</th>
            <td>{{ $pengembalian->id_pinjam }}</td>
        </tr>

        <tr>
            <th>Nama Peminjam</th>
            <td>{{ $pengembalian->peminjaman->user->name ?? '-' }}</td>
        </tr>

        <tr>
            <th>Tanggal Kembali</th>
            <td>{{ $pengembalian->tanggal_kembali->format('d-m-Y') }}</td>
        </tr>

        <tr>
            <th>Kondisi Alat</th>
            <td>{{ $pengembalian->kondisi_alat }}</td>
        </tr>

        <tr>
            <th>Denda</th>
            <td>
                Rp{{ number_format((float) $pengembalian->denda, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <th>Diterima Oleh</th>
            <td>{{ $pengembalian->diterima_oleh }}</td>
        </tr>
    </table>

    <h4 class="mt-4">Daftar Alat</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Alat</th>
                <th>Jumlah</th>
            </tr>
        </thead>

        <tbody>
            @foreach($pengembalian->peminjaman->detailPeminjamans as $detail)
                <tr>
                    <td>{{ $detail->alat->nama_alat ?? 'Alat tidak tersedia' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.pengembalian.edit', $pengembalian->id_kembali) }}"
       class="btn btn-warning">
        Edit
    </a>

    <a href="{{ route('admin.pengembalian.index') }}"
       class="btn btn-secondary">
        Kembali
    </a>

</div>
@endsection
