
@extends('layouts.petugas')

@section('content')
<style>
    .laporan-page {
        color: #1e293b;
        width: 100%;
    }

    .laporan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .laporan-header h2 {
        font-size: 26px;
        font-weight: 750;
        margin: 0 0 7px;
        color: #172554;
    }

    .laporan-header p {
        color: #64748b;
        margin: 0;
        font-size: 14px;
    }

    .btn-cetak {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 18px;
        border-radius: 9px;
        background: #16a34a;
        color: white;
        text-decoration: none;
        font-weight: 600;
        border: none;
        transition: .2s;
    }

    .btn-cetak:hover {
        background: #15803d;
        color: white;
        transform: translateY(-2px);
    }

    .laporan-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 25px;
    }

    .laporan-stat {
        background: white;
        padding: 20px;
        border-radius: 13px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
    }

    .laporan-stat .stat-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 10px;
    }

    .laporan-stat .stat-number {
        font-size: 25px;
        font-weight: 750;
        color: #172554;
    }

    .laporan-stat .stat-icon {
        font-size: 23px;
        margin-bottom: 12px;
    }

    .laporan-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        padding: 22px;
        margin-bottom: 23px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
    }

    .laporan-card-title {
        font-size: 17px;
        font-weight: 700;
        color: #172554;
        margin: 0 0 18px;
    }

    .laporan-filter {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .laporan-field label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }

    .laporan-field input,
    .laporan-field select {
        width: 100%;
        height: 43px;
        padding: 0 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        outline: none;
        background: #fff;
        color: #334155;
        font-size: 13px;
        box-sizing: border-box;
    }

    .laporan-field input:focus,
    .laporan-field select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
    }

    .laporan-filter-actions {
        display: flex;
        gap: 10px;
        margin-top: 18px;
        flex-wrap: wrap;
    }

    .btn-filter,
    .btn-reset {
        padding: 10px 17px;
        border-radius: 8px;
        border: none;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-filter {
        background: #2563eb;
        color: white;
    }

    .btn-filter:hover {
        background: #1d4ed8;
    }

    .btn-reset {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-reset:hover {
        background: #cbd5e1;
    }

    .laporan-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .laporan-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px;
        font-size: 13px;
    }

    .laporan-table thead {
        background: #f1f5f9;
    }

    .laporan-table th {
        padding: 14px 12px;
        text-align: left;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .laporan-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
        vertical-align: middle;
    }

    .laporan-table tbody tr:hover {
        background: #f8fafc;
    }

    .nama-peminjam {
        font-weight: 700;
        color: #1e293b;
    }

    .email-peminjam {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .status-disetujui {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-pengajuan_pengembalian {
        background: #cffafe;
        color: #0e7490;
    }

    .status-dikembalikan {
        background: #dcfce7;
        color: #15803d;
    }

    .laporan-empty {
        text-align: center;
        padding: 45px 15px !important;
        color: #94a3b8 !important;
    }

    .laporan-empty-icon {
        font-size: 38px;
        margin-bottom: 10px;
    }

    .laporan-pagination {
        margin-top: 20px;
    }

    .laporan-alert {
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 20px;
        background: #dcfce7;
        color: #166534;
    }

    @media(max-width: 1100px) {
        .laporan-filter {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 650px) {
        .laporan-stats {
            grid-template-columns: 1fr;
        }

        .laporan-filter {
            grid-template-columns: 1fr;
        }

        .laporan-card {
            padding: 15px;
        }

        .laporan-header h2 {
            font-size: 22px;
        }
    }
</style>

<div class="laporan-page">

    {{-- HEADER --}}
    <div class="laporan-header">
        <div>
            <h2>📊 Laporan Peminjaman</h2>
            <p>Kelola, pantau, dan cetak seluruh laporan peminjaman alat bengkel.</p>
        </div>

        <a href="{{ route('petugas.laporan.cetak', request()->query()) }}"
           target="_blank"
           class="btn-cetak">
            🖨️ Cetak Laporan
        </a>
    </div>

    @if(session('success'))
        <div class="laporan-alert">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- STATISTIK --}}
    <div class="laporan-stats">
        <div class="laporan-stat">
            <div class="stat-icon">📋</div>
            <div class="stat-label">Total Data Laporan</div>
            <div class="stat-number">{{ $laporans->total() }}</div>
        </div>

        <div class="laporan-stat">
            <div class="stat-icon">📅</div>
            <div class="stat-label">Periode Laporan</div>
            <div class="stat-number" style="font-size:17px;">
                {{ request('tanggal_mulai') ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d/m/Y') : 'Semua tanggal' }}
                <br>
                <span style="font-size:12px;color:#94a3b8;font-weight:500;">
                    sampai
                    {{ request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') : 'Sekarang' }}
                </span>
            </div>
        </div>

        <div class="laporan-stat">
            <div class="stat-icon">🔎</div>
            <div class="stat-label">Status Filter</div>
            <div class="stat-number" style="font-size:19px;">
                {{ request('status') ? ucwords(str_replace('_', ' ', request('status'))) : 'Semua Status' }}
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="laporan-card">
        <h3 class="laporan-card-title">🔍 Filter dan Pencarian Laporan</h3>

        <form action="{{ route('petugas.laporan.index') }}" method="GET">
            <div class="laporan-filter">

                <div class="laporan-field">
                    <label>Tanggal Mulai</label>
                    <input type="date"
                           name="tanggal_mulai"
                           value="{{ request('tanggal_mulai') }}">
                </div>

                <div class="laporan-field">
                    <label>Tanggal Akhir</label>
                    <input type="date"
                           name="tanggal_akhir"
                           value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="laporan-field">
                    <label>Status Peminjaman</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="menunggu" @selected(request('status') == 'menunggu')>Menunggu</option>
                        <option value="disetujui" @selected(request('status') == 'disetujui')>Disetujui</option>
                        <option value="ditolak" @selected(request('status') == 'ditolak')>Ditolak</option>
                        <option value="pengajuan_pengembalian" @selected(request('status') == 'pengajuan_pengembalian')>Pengajuan Pengembalian</option>
                        <option value="dikembalikan" @selected(request('status') == 'dikembalikan')>Dikembalikan</option>
                    </select>
                </div>

                <div class="laporan-field">
                    <label>Cari Nama atau Email</label>
                    <input type="text"
                           name="cari"
                           placeholder="Masukkan nama pengguna..."
                           value="{{ request('cari') }}">
                </div>

            </div>

            <div class="laporan-filter-actions">
                <button type="submit" class="btn-filter">
                    🔍 Terapkan Filter
                </button>

                <a href="{{ route('petugas.laporan.index') }}"
                   class="btn-reset">
                    ↻ Reset Filter
                </a>
            </div>
        </form>
    </div>

    {{-- TABEL --}}
    <div class="laporan-card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:18px;">
            <h3 class="laporan-card-title" style="margin:0;">
                📑 Data Laporan Peminjaman
            </h3>

            <span style="font-size:12px;color:#64748b;">
                Menampilkan {{ $laporans->count() }} dari {{ $laporans->total() }} transaksi
            </span>
        </div>

        <div class="laporan-table-wrapper">
            <table class="laporan-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Peminjam</th>
                        <th>Alat Dipinjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Tanggal Dikembalikan</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($laporans as $index => $peminjaman)
                        @php
                            $pengembalian = $peminjaman->pengembalians->first();
                            $statusClass = 'status-' . $peminjaman->status;
                        @endphp

                        <tr>
                            <td>{{ $laporans->firstItem() + $index }}</td>

                            <td>
                                <div class="nama-peminjam">
                                    {{ $peminjaman->user->name ?? 'Pengguna dihapus' }}
                                </div>
                                <div class="email-peminjam">
                                    {{ $peminjaman->user->email ?? '-' }}
                                </div>
                            </td>

                            <td>
                                @forelse($peminjaman->detailPeminjamans as $detail)
                                    <div>
                                        {{ $detail->alat->nama_alat ?? 'Alat dihapus' }}
                                        <strong>({{ $detail->jumlah }})</strong>
                                    </div>
                                @empty
                                    -
                                @endforelse
                            </td>

                            <td>
                                {{ $peminjaman->tanggal_pinjam
                                    ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $peminjaman->tanggal_kembali
                                    ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $pengembalian && $pengembalian->tanggal_kembali
                                    ? \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td>
                                <span class="status-badge {{ $statusClass }}">
                                    {{ ucwords(str_replace('_', ' ', $peminjaman->status)) }}
                                </span>
                            </td>

                            <td style="font-weight:700;color:#dc2626;white-space:nowrap;">
                                Rp{{ number_format((float) $peminjaman->denda, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="laporan-empty">
                                <div class="laporan-empty-icon">📂</div>
                                <strong>Belum Ada Data Laporan</strong>
                                <div style="font-size:12px;margin-top:5px;">
                                    Data transaksi akan tampil di sini setelah tersedia.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="laporan-pagination">
            {{ $laporans->links() }}
        </div>
    </div>

</div>
@endsection
