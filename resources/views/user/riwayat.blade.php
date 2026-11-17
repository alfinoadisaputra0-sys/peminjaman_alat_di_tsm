
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat - BENGKEL ALAT ALVINO</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f8ff;
            color: #172554;
        }

        .navbar {
            background: #102a56;
            color: white;
            padding: 17px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: #2563eb;
            display: grid;
            place-items: center;
        }

        .brand-icon svg {
            width: 25px;
            height: 25px;
            stroke: white;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .brand h2 { margin: 0; font-size: 19px; }
        .brand small { color: #bfdbfe; font-size: 10px; letter-spacing: 2px; }

        .user-info {
            background: rgba(255,255,255,.1);
            padding: 10px 16px;
            border-radius: 9px;
            font-size: 13px;
        }

        .container {
            max-width: 1250px;
            margin: 35px auto;
            padding: 0 22px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .page-header h1 {
            color: #102a56;
            font-size: 27px;
            margin: 0 0 8px;
        }

        .page-header p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }

        .card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 15px;
            padding: 23px;
            margin-bottom: 22px;
            box-shadow: 0 5px 20px rgba(15,35,75,.04);
        }

        .info-card {
            background: #eff6ff;
            border: 1px solid #dbeafe;
        }

        .info-card h3 {
            margin: 0 0 9px;
            color: #102a56;
        }

        .info-card p {
            color: #475569;
            font-size: 13px;
            line-height: 1.8;
            margin: 0;
        }

        .table-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .table-title h3 {
            margin: 0;
            color: #102a56;
        }

        .total-data {
            background: #eff6ff;
            color: #2563eb;
            padding: 7px 13px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        th {
            background: #eff6ff;
            color: #1e3a8a;
            padding: 14px 12px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #edf2f7;
            color: #475569;
            font-size: 13px;
        }

        tbody tr:hover {
            background: #f8fbff;
        }

        .alat-item {
            color: #102a56;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .badge {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge.menunggu {
            background: #fef3c7;
            color: #92400e;
        }

        .badge.disetujui {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge.pengajuan_pengembalian {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .badge.dikembalikan {
            background: #dcfce7;
            color: #15803d;
        }

        .badge.ditolak {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge.dibatalkan {
            background: #e2e8f0;
            color: #475569;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
        }

        .btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #eaf1ff;
            color: #1d4ed8;
        }

        .btn-secondary:hover {
            background: #dbeafe;
        }

        .btn-return {
            background: #2563eb;
            color: white;
        }

        .waiting-text {
            color: #7e22ce;
            font-size: 12px;
            font-weight: 700;
        }

        .success-text {
            color: #15803d;
            font-size: 12px;
            font-weight: 700;
        }

        .rejected-text {
            color: #dc2626;
            font-size: 12px;
            font-weight: 700;
        }

        .empty-state {
            text-align: center;
            padding: 35px 15px;
            color: #64748b;
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            stroke: #93c5fd;
            fill: none;
            stroke-width: 1.5;
            margin-bottom: 12px;
        }

        .empty-state strong {
            display: block;
            color: #102a56;
            font-size: 16px;
        }

        .empty-state p {
            font-size: 13px;
        }

        .pagination {
            margin-top: 22px;
        }

        .footer {
            text-align: center;
            padding: 22px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 12px;
        }

        .footer strong {
            color: #2563eb;
        }

        .alert {
            padding: 14px 17px;
            border-radius: 9px;
            margin-bottom: 17px;
            font-size: 13px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        @media(max-width:650px) {
            .container { padding: 0 13px; }
            .card { padding: 15px; }
            .page-header h1 { font-size: 23px; }
            .navbar { padding: 15px 18px; }
        }
    </style>
</head>

<body>

<header class="navbar">
    <div class="brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24">
                <path d="M14.7 6.3a5 5 0 0 0-6.4 6.4L3 18l3 3 5.3-5.3a5 5 0 0 0 6.4-6.4L14 13l-3-3z"/>
            </svg>
        </div>
        <div>
            <h2>BENGKEL ALAT ALVINO</h2>
            <small>SISTEM PEMINJAMAN ALAT</small>
        </div>
    </div>

    <div class="user-navbar-actions">

        @include('user.partials.notifikasi')

        <div class="user-info">
            Pengguna: <strong>{{ auth()->user()->name }}</strong>
        </div>

    </div>
</header>

<main class="container">

    <div class="page-header">
        <div>
            <h1>Riwayat Peminjaman</h1>
            <p>Pantau seluruh transaksi peminjaman dan pengembalian alat Anda.</p>
        </div>

        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
            ← Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            ⚠ {{ session('error') }}
        </div>
    @endif

    <div class="card info-card">
        <h3>Informasi Riwayat Peminjaman</h3>
        <p>
            Halaman ini menampilkan seluruh transaksi peminjaman alat
            yang pernah Anda ajukan. Jika peminjaman sudah disetujui,
            Anda dapat mengajukan pengembalian melalui tombol yang tersedia.
        </p>
    </div>

    <div class="card">

        <div class="table-title">
            <h3>Daftar Transaksi</h3>

            <span class="total-data">
                {{ $peminjamans->count() }} Data
            </span>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Alat Dipinjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($peminjamans as $index => $peminjaman)

                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                @forelse($peminjaman->detailPeminjamans as $detail)
                                    <div class="alat-item">
                                        {{ $detail->alat->nama_alat ?? 'Alat dihapus' }}
                                        <strong>({{ $detail->jumlah }})</strong>
                                    </div>
                                @empty
                                    -
                                @endforelse
                            </td>

                            <td>
                                {{ $peminjaman->tanggal_pinjam
                                    ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $peminjaman->tanggal_kembali
                                    ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>
                                <span class="badge {{ $peminjaman->status }}">
                                    {{ ucwords(str_replace('_', ' ', $peminjaman->status)) }}
                                </span>
                            </td>

                            <td style="color:#dc2626;font-weight:700;white-space:nowrap;">
                                Rp{{ number_format((float) $peminjaman->denda, 0, ',', '.') }}
                            </td>

                            <td>
                                @if($peminjaman->status == 'disetujui')

                                    <form
                                        action="{{ route('user.pengembalian.ajukan', $peminjaman->id_pinjam) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin mengajukan pengembalian alat ini?')"
                                    >
                                        @csrf

                                        <button type="submit" class="btn btn-return">
                                            Ajukan Pengembalian
                                        </button>
                                    </form>

                                @elseif($peminjaman->status == 'pengajuan_pengembalian')

                                    <span class="waiting-text">
                                        Menunggu Petugas
                                    </span>

                                @elseif($peminjaman->status == 'dikembalikan')

                                    <span class="success-text">
                                        ✓ Selesai
                                    </span>

                                @elseif($peminjaman->status == 'ditolak')

                                    <span class="rejected-text">
                                        ✕ Ditolak
                                    </span>

                                @else

                                    <span style="color:#94a3b8;font-size:12px;">
                                        Menunggu persetujuan
                                    </span>

                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M4 4h16v16H4z"/>
                                        <path d="M8 9h8M8 13h8M8 17h5"/>
                                    </svg>

                                    <strong>Belum Ada Riwayat Peminjaman</strong>

                                    <p>
                                        Anda belum memiliki transaksi peminjaman alat.
                                    </p>

                                    <a
                                        href="{{ route('user.peminjaman.index') }}"
                                        class="btn"
                                    >
                                        Pinjam Alat Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($peminjamans, 'links'))
            <div class="pagination">
                {{ $peminjamans->links() }}
            </div>
        @endif

    </div>

</main>

<footer class="footer">
    © {{ date('Y') }} BENGKEL ALAT ALVINO.
    By <strong>Alvino Adi Saputra</strong>.
</footer>

</body>
</html>
