@extends('layouts.petugas')

@section('title', 'Pengembalian Alat')
@section('page-title', 'Pengembalian Alat')

@section('content')

<style>
    .heading {
        margin-bottom: 22px;
    }

    .heading h2 {
        font-size: 23px;
        margin-bottom: 7px;
    }

    .heading p {
        color: #788598;
        font-size: 14px;
    }

    .alert {
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 18px;
        font-size: 14px;
    }

    .success {
        background: #d9f5e5;
        color: #176b40;
    }

    .danger {
        background: #ffe1e1;
        color: #a52d2d;
    }

    .card {
        background: white;
        padding: 22px;
        border-radius: 10px;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    th, td {
        text-align: left;
        vertical-align: top;
        padding: 13px 12px;
        border-bottom: 1px solid #edf0f4;
        font-size: 13px;
    }

    th {
        background: #f7f9fc;
        color: #536176;
    }

    .alat-list {
        line-height: 1.8;
    }

    .form-kondisi {
        min-width: 190px;
    }

    .form-kondisi input {
        width: 100%;
        padding: 9px;
        border: 1px solid #dce2ea;
        border-radius: 6px;
        margin-bottom: 8px;
    }

    .btn {
        border: 0;
        padding: 10px 12px;
        border-radius: 6px;
        color: white;
        background: #16834b;
        cursor: pointer;
        font-size: 12px;
    }

    .btn:hover {
        background: #116b3c;
    }

    .empty {
        text-align: center;
        padding: 30px;
        color: #8792a2;
    }

    small {
        color: #788598;
    }
</style>

<div class="heading">
    <h2>Daftar Pengajuan Pengembalian</h2>
    <p>
        Periksa kondisi alat sebelum menyelesaikan pengembalian.
    </p>
</div>

@if(session('success'))
    <div class="alert success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pengguna</th>
                    <th>Alat yang Dikembalikan</th>
                    <th>Batas Pengembalian</th>
                    <th>Proses Pengembalian</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengembalians as $peminjaman)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>
                                {{ $peminjaman->user->name ?? '-' }}
                            </strong>
                            <br>
                            <small>
                                {{ $peminjaman->user->email ?? '-' }}
                            </small>
                        </td>

                        <td class="alat-list">
                            @foreach($peminjaman->detailPeminjamans as $detail)
                                {{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                                ({{ $detail->jumlah }} unit)
                                <br>
                            @endforeach
                        </td>

                        <td>
                            @if($peminjaman->tanggal_kembali)
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <form
                                class="form-kondisi"
                                action="{{ route('petugas.pengembalian.proses', $peminjaman->id_pinjam) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menyelesaikan pengembalian ini? Stok alat akan bertambah.');"
                            >
                                @csrf

                                <input
                                    type="text"
                                    name="kondisi_alat"
                                    placeholder="Contoh: Baik, lengkap"
                                    maxlength="255"
                                    required
                                >

                                <button type="submit" class="btn">
                                    Proses Pengembalian
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Belum ada pengajuan pengembalian yang menunggu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
