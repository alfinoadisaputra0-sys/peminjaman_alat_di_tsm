
@extends('layouts.petugas')

@section('title', 'Data Transaksi')
@section('page-title', 'Data Transaksi')

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
        font-size: 14px;
        color: #788598;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 23px;
    }

    .stat-card {
        background: white;
        padding: 19px;
        border-radius: 9px;
        border-left: 4px solid #35669a;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .stat-card small {
        display: block;
        color: #718096;
        margin-bottom: 9px;
        font-size: 12px;
    }

    .stat-card strong {
        font-size: 25px;
        color: #263247;
    }

    .filter-card,
    .table-card {
        background: white;
        padding: 21px;
        border-radius: 10px;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
        margin-bottom: 20px;
    }

    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filter-form input,
    .filter-form select {
        padding: 11px 12px;
        border: 1px solid #dce2ea;
        border-radius: 6px;
        font-size: 13px;
    }

    .filter-form input {
        flex: 1;
        min-width: 200px;
    }

    .btn {
        border: 0;
        border-radius: 6px;
        padding: 11px 16px;
        color: white;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-search {
        background: #35669a;
    }

    .btn-reset {
        background: #64748b;
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        min-width: 1050px;
        border-collapse: collapse;
    }

    th, td {
        padding: 13px 11px;
        text-align: left;
        vertical-align: top;
        border-bottom: 1px solid #edf0f4;
        font-size: 12px;
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
        padding: 6px 9px;
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

    .pengajuan_pengembalian {
        background: #e8e1ff;
        color: #6241a5;
    }

    .dikembalikan {
        background: #dceaff;
        color: #245a9b;
    }

    .denda {
        color: #a52d2d;
        font-weight: bold;
    }

    .empty {
        text-align: center;
        padding: 30px;
        color: #8792a2;
    }

    .pagination {
        margin-top: 20px;
    }

    .pagination nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination nav div {
        margin-top: 5px;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 7px 11px;
        margin: 2px;
        border: 1px solid #e1e6ed;
        border-radius: 5px;
        text-decoration: none;
        color: #35669a;
        font-size: 12px;
    }

    .pagination [aria-current="page"] span {
        background: #35669a;
        color: white;
    }

    @media(max-width: 800px) {
        .stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 500px) {
        .stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="heading">
    <h2>Seluruh Data Transaksi</h2>
    <p>
        Pantau seluruh aktivitas peminjaman dan pengembalian alat bengkel.
    </p>
</div>

{{-- Statistik --}}
<div class="stats">

    <div class="stat-card">
        <small>Total Transaksi</small>
        <strong>{{ $totalTransaksi }}</strong>
    </div>

    <div class="stat-card">
        <small>Menunggu Persetujuan</small>
        <strong>{{ $totalMenunggu }}</strong>
    </div>

    <div class="stat-card">
        <small>Peminjaman Disetujui</small>
        <strong>{{ $totalDisetujui }}</strong>
    </div>

    <div class="stat-card">
        <small>Peminjaman Ditolak</small>
        <strong>{{ $totalDitolak }}</strong>
    </div>

    <div class="stat-card">
        <small>Menunggu Pengembalian</small>
        <strong>{{ $totalPengajuanPengembalian }}</strong>
    </div>

    <div class="stat-card">
        <small>Sudah Dikembalikan</small>
        <strong>{{ $totalDikembalikan }}</strong>
    </div>

</div>

{{-- Pencarian dan filter --}}
<div class="filter-card">

    <form action="{{ route('petugas.transaksi.index') }}"
          method="GET"
          class="filter-form">

        <input
            type="text"
            name="cari"
            placeholder="Cari nama atau email pengguna..."
            value="{{ request('cari') }}"
        >

        <select name="status">
            <option value="">Semua Status</option>

            <option value="menunggu"
                {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                Menunggu
            </option>

            <option value="disetujui"
                {{ request('status') == 'disetujui' ? 'selected' : '' }}>
                Disetujui
            </option>

            <option value="ditolak"
                {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                Ditolak
            </option>

            <option value="pengajuan_pengembalian"
                {{ request('status') == 'pengajuan_pengembalian' ? 'selected' : '' }}>
                Pengajuan Pengembalian
            </option>

            <option value="dikembalikan"
                {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>
                Dikembalikan
            </option>
        </select>

        <button type="submit" class="btn btn-search">
            Cari Transaksi
        </button>

        <a href="{{ route('petugas.transaksi.index') }}"
           class="btn btn-reset">
            Reset
        </a>

    </form>

</div>

{{-- Tabel transaksi --}}
<div class="table-card">

    <div class="table-wrap">

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pengguna</th>
                    <th>Tanggal Pinjam</th>
                    <th>Daftar Alat</th>
                    <th>Batas Kembali</th>
                    <th>Pengembalian Aktual</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transaksis as $peminjaman)

                    <tr>
                        <td>
                            {{ $transaksis->firstItem() + $loop->index }}
                        </td>

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
                                ({{ $detail->jumlah }} unit)
                                <br>

                            @empty
                                -
                            @endforelse
                        </td>

                        <td>
                            {{ $peminjaman->tanggal_kembali
                                ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y')
                                : '-' }}
                        </td>

                        <td>
                            @if($peminjaman->pengembalians->isNotEmpty())
                                {{ \Carbon\Carbon::parse(
                                    $peminjaman->pengembalians->first()->tanggal_kembali
                                )->format('d-m-Y') }}
                            @else
                                Belum dikembalikan
                            @endif
                        </td>

                        <td>
                            <span class="status {{ $peminjaman->status }}">
                                {{ ucfirst(str_replace('_', ' ', $peminjaman->status)) }}
                            </span>
                        </td>

                        <td class="denda">
                            Rp{{ number_format((float) $peminjaman->denda, 0, ',', '.') }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="empty">
                            Tidak ada data transaksi yang ditemukan.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

    </div>

    <div class="pagination">
        {{ $transaksis->links() }}
    </div>

</div>

@endsection
