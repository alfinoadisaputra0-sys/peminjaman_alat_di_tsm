
@extends('layouts.petugas')

@section('title', 'Pengajuan Peminjaman')
@section('page-title', 'Pengajuan Peminjaman')

@section('content')

<style>
    .page-heading {
        margin-bottom: 22px;
    }

    .page-heading h2 {
        font-size: 23px;
        margin-bottom: 7px;
    }

    .page-heading p {
        color: #788598;
        font-size: 14px;
    }

    .alert {
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 18px;
        font-size: 14px;
    }

    .alert-success {
        background: #d9f5e5;
        color: #176b40;
    }

    .alert-danger {
        background: #ffe1e1;
        color: #a52d2d;
    }

    .table-card {
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
        border-collapse: collapse;
        min-width: 850px;
    }

    th, td {
        padding: 14px 12px;
        border-bottom: 1px solid #edf0f4;
        text-align: left;
        vertical-align: top;
        font-size: 13px;
    }

    th {
        background: #f7f9fc;
        color: #536176;
        white-space: nowrap;
    }

    .alat-list {
        line-height: 1.8;
    }

    .status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        white-space: nowrap;
    }

    .menunggu {
        background: #fff1cf;
        color: #936000;
    }

    .disetujui {
        background: #d9f5e5;
        color: #167342;
    }

    .ditolak {
        background: #ffe0e0;
        color: #a52d2d;
    }

    .dikembalikan {
        background: #dceaff;
        color: #245a9b;
    }

    .actions {
        display: flex;
        gap: 7px;
        align-items: center;
    }

    .btn {
        border: 0;
        border-radius: 6px;
        padding: 9px 12px;
        color: white;
        font-size: 12px;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-approve {
        background: #16834b;
    }

    .btn-reject {
        background: #bd3540;
    }

    .btn-approve:hover {
        background: #116b3c;
    }

    .btn-reject:hover {
        background: #982832;
    }

    .processed {
        color: #8792a2;
        font-size: 12px;
    }

    .empty {
        text-align: center;
        padding: 30px;
        color: #8792a2;
    }
</style>

<div class="page-heading">
    <h2>Daftar Pengajuan Peminjaman</h2>
    <p>
        Periksa permintaan pengguna sebelum menyetujui atau menolaknya.
    </p>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="table-card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pengguna</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Daftar Alat</th>
                    <th>Batas Pengembalian</th>
                    <th>Status</th>
                    <th>Aksi Petugas</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>
                                {{ $peminjaman->user->name ?? 'Pengguna tidak ditemukan' }}
                            </strong>
                            <br>
                            <small>
                                {{ $peminjaman->user->email ?? '-' }}
                            </small>
                        </td>

                        <td>
                            {{ $peminjaman->tanggal_pinjam
                                ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y')
                                : '-' }}
                        </td>

                        <td class="alat-list">
                            @forelse($peminjaman->detailPeminjamans as $detail)
                                {{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                                — {{ $detail->jumlah }} unit
                                <br>
                            @empty
                                -
                            @endforelse
                        </td>

                        <td>
                            @if($peminjaman->tanggal_kembali)
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}
                            @else
                                Belum ditentukan
                            @endif
                        </td>

                        <td>
                            <span class="status {{ $peminjaman->status }}">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </td>

                        <td>
                            @if($peminjaman->status === 'menunggu')
                                <div class="actions">
                                    <form
                                        action="{{ route('petugas.peminjaman.setujui', $peminjaman->id_pinjam) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menyetujui peminjaman ini? Stok alat akan dikurangi.');"
                                    >
                                        @csrf
                                        <button type="submit" class="btn btn-approve">
                                            Setujui
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('petugas.peminjaman.tolak', $peminjaman->id_pinjam) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menolak pengajuan ini?');"
                                    >
                                        @csrf
                                        <button type="submit" class="btn btn-reject">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="processed">
                                    Sudah diproses
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">
                            Belum ada data pengajuan peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
