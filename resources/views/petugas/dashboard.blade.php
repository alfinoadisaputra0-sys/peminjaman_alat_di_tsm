
@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')
@section('page-title', 'Dashboard Petugas')

@section('content')

<style>
    .dashboard {
        width: 100%;
    }

    .welcome {
        background: linear-gradient(120deg, #102a56, #2563eb);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 27px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(37,99,235,.12);
    }

    .welcome::after {
        content: "";
        position: absolute;
        width: 190px;
        height: 190px;
        border: 30px solid rgba(255,255,255,.08);
        border-radius: 50%;
        right: -45px;
        top: -80px;
    }

    .welcome h2 {
        font-size: 25px;
        margin-bottom: 12px;
        font-weight: 700;
    }

    .welcome p {
        color: #dbeafe;
        font-size: 14px;
        line-height: 1.8;
        max-width: 650px;
    }

    .welcome-badge {
        display: inline-block;
        margin-top: 15px;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.2);
        color: white;
        padding: 8px 14px;
        border-radius: 25px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .section-heading {
        color: #102a56;
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 17px;
    }

    /* STATISTIK */
    .stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 17px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 21px;
        border-radius: 13px;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #2563eb;
        box-shadow: 0 4px 15px rgba(15,35,75,.03);
        transition: .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(37,99,235,.08);
    }

    .stat-card .label {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 12px;
        line-height: 1.5;
    }

    .stat-card .number {
        font-size: 28px;
        font-weight: 750;
        color: #2563eb;
    }

    /* SECTION CARD */
    .section-card {
        background: white;
        padding: 23px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(15,35,75,.03);
        margin-bottom: 23px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .section-header h3 {
        font-size: 17px;
        font-weight: 700;
        color: #102a56;
        margin: 0;
    }

    .section-header a {
        text-decoration: none;
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
    }

    .section-header a:hover {
        color: #1d4ed8;
    }

    /* TABEL */
    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    th {
        padding: 14px 12px;
        text-align: left;
        background: #eff6ff;
        color: #1e3a8a;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    td {
        padding: 15px 12px;
        text-align: left;
        border-bottom: 1px solid #edf2f7;
        font-size: 13px;
        color: #475569;
    }

    tbody tr:hover {
        background: #f8fbff;
    }

    /* STATUS */
    .status {
        display: inline-block;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .disetujui {
        background: #dcfce7;
        color: #166534;
    }

    .ditolak {
        background: #fee2e2;
        color: #b91c1c;
    }

    .dikembalikan {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .pengajuan_pengembalian {
        background: #f3e8ff;
        color: #7e22ce;
    }

    .empty {
        text-align: center;
        color: #94a3b8;
        padding: 30px;
    }

    /* QUICK MENU */
    .quick-menu {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .quick-menu a {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 19px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        text-decoration: none;
        background: white;
        transition: .2s;
    }

    .quick-menu a:hover {
        border-color: #93c5fd;
        background: #f8fbff;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(37,99,235,.06);
    }

    .quick-icon {
        width: 43px;
        height: 43px;
        min-width: 43px;
        border-radius: 10px;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
    }

    .quick-icon svg {
        width: 22px;
        height: 22px;
        stroke: currentColor;
        fill: none;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .quick-menu strong {
        display: block;
        color: #102a56;
        font-size: 14px;
        margin-bottom: 7px;
    }

    .quick-menu span {
        color: #64748b;
        font-size: 12px;
        line-height: 1.6;
    }

    @media(max-width: 1100px) {
        .stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 600px) {
        .stats,
        .quick-menu {
            grid-template-columns: 1fr;
        }

        .welcome {
            padding: 23px;
        }

        .welcome h2 {
            font-size: 21px;
        }

        .section-card {
            padding: 15px;
        }
    }
</style>

<div class="dashboard">

    <!-- WELCOME -->
    <div class="welcome">

        <h2>
            Selamat Datang, {{ auth()->user()->name }}!
        </h2>

        <p>
            Selamat bekerja di BENGKEL ALAT ALVINO.
            Kelola pengajuan peminjaman, proses pengembalian alat,
            dan pantau aktivitas transaksi bengkel TSM melalui dashboard ini.
        </p>

        <span class="welcome-badge">
            PETUGAS BENGKEL
        </span>

    </div>

    <!-- STATISTIK -->
    <h3 class="section-heading">Ringkasan Aktivitas</h3>

    <div class="stats">

        <div class="stat-card">
            <div class="label">Total Pengguna</div>
            <div class="number">{{ $jumlahUser }}</div>
        </div>

        <div class="stat-card">
            <div class="label">Total Alat</div>
            <div class="number">{{ $jumlahAlat }}</div>
        </div>

        <div class="stat-card">
            <div class="label">Menunggu Persetujuan</div>
            <div class="number">{{ $jumlahMenunggu }}</div>
        </div>

        <div class="stat-card">
            <div class="label">Peminjaman Disetujui</div>
            <div class="number">{{ $jumlahDisetujui }}</div>
        </div>

        <div class="stat-card">
            <div class="label">Peminjaman Ditolak</div>
            <div class="number">{{ $jumlahDitolak }}</div>
        </div>

        <div class="stat-card">
            <div class="label">Sudah Dikembalikan</div>
            <div class="number">{{ $jumlahDikembalikan }}</div>
        </div>

        <div class="stat-card">
            <div class="label">Data Pengembalian</div>
            <div class="number">{{ $jumlahPengembalian }}</div>
        </div>

    </div>

    <!-- PEMINJAMAN TERBARU -->
    <div class="section-card">

        <div class="section-header">

            <h3>Pengajuan Peminjaman Terbaru</h3>

            <a href="{{ route('petugas.peminjaman.index') }}">
                Lihat Semua →
            </a>

        </div>

        <div class="table-wrap">

            <table>

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pengguna</th>
                        <th>Tanggal Pinjam</th>
                        <th>Alat</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($pengajuanTerbaru as $peminjaman)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $peminjaman->user->name ?? 'Pengguna tidak ditemukan' }}
                            </td>

                            <td>
                                {{ $peminjaman->tanggal_pinjam
                                    ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>
                                @forelse ($peminjaman->detailPeminjamans as $detail)

                                    {{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                                    ({{ $detail->jumlah }}){{ !$loop->last ? ', ' : '' }}

                                @empty

                                    -

                                @endforelse
                            </td>

                            <td>

                                <span class="status {{ $peminjaman->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $peminjaman->status)) }}
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada pengajuan peminjaman.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <!-- MENU CEPAT -->
    <div class="section-card">

        <div class="section-header">
            <h3>Akses Cepat</h3>
        </div>

        <div class="quick-menu">

            <a href="{{ route('petugas.peminjaman.index') }}">

                <div class="quick-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M8 2v4M16 2v4M3 10h18"/>
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M8 14h8"/>
                    </svg>
                </div>

                <div>
                    <strong>Pengajuan Peminjaman</strong>
                    <span>Periksa dan tindak lanjuti pengajuan pengguna.</span>
                </div>

            </a>

            <a href="{{ route('petugas.pengembalian.index') }}">

                <div class="quick-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 12a9 9 0 1 0 3-6.7"/>
                        <path d="M3 4v5h5"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                </div>

                <div>
                    <strong>Pengembalian Alat</strong>
                    <span>Kelola proses penerimaan alat yang dikembalikan.</span>
                </div>

            </a>

            <a href="{{ route('petugas.transaksi.index') }}">

                <div class="quick-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 4h16v17H4z"/>
                        <path d="M8 8h8M8 12h8M8 16h5"/>
                    </svg>
                </div>

                <div>
                    <strong>Data Transaksi</strong>
                    <span>Lihat seluruh transaksi peminjaman dan pengembalian.</span>
                </div>

            </a>

            <a href="{{ route('petugas.laporan.index') }}">

                <div class="quick-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 19V5M4 19h17"/>
                        <path d="m7 15 4-4 3 2 6-7"/>
                    </svg>
                </div>

                <div>
                    <strong>Laporan Transaksi</strong>
                    <span>Lihat laporan peminjaman dan pengembalian.</span>
                </div>

            </a>

        </div>

    </div>

</div>

@endsection
