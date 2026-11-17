
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Alat - BENGKEL ALAT ALVINO</title>

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
            align-items: center;
            justify-content: space-between;
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
            background: #2563eb;
            border-radius: 12px;
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
            max-width: 1200px;
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
            margin: 0 0 8px;
            color: #102a56;
            font-size: 27px;
        }

        .page-header p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }

        .card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 5px 20px rgba(15,35,75,.04);
        }

        .card-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .card-heading h3 {
            margin: 0;
            color: #102a56;
        }

        .total {
            background: #eff6ff;
            color: #2563eb;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            min-width: 1050px;
            border-collapse: collapse;
        }

        th {
            background: #eff6ff;
            color: #1e3a8a;
            padding: 15px 13px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
        }

        td {
            padding: 16px 13px;
            border-bottom: 1px solid #edf2f7;
            font-size: 13px;
            color: #475569;
            vertical-align: middle;
        }

        tbody tr:hover { background: #f8fbff; }

        .alat-name {
            font-weight: 700;
            color: #102a56;
        }

        .stock {
            display: inline-block;
            padding: 6px 10px;
            background: #dcfce7;
            color: #15803d;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .empty-stock {
            background: #fee2e2;
            color: #b91c1c;
        }

        .condition {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .condition-baik {
            background: #dcfce7;
            color: #15803d;
        }

        .condition-ringan {
            background: #fef3c7;
            color: #b45309;
        }

        .condition-berat {
            background: #fee2e2;
            color: #b91c1c;
        }

        .location {
            color: #1d4ed8;
            font-weight: 600;
        }

        .form-pinjam {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-pinjam input {
            width: 65px;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        .form-pinjam input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px #dbeafe;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 16px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
            white-space: nowrap;
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

        .btn-disabled {
            background: #cbd5e1;
            cursor: not-allowed;
        }

        .message {
            padding: 14px 17px;
            border-radius: 10px;
            margin-bottom: 17px;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 25px;
            padding: 20px 0;
            border-top: 1px solid #e2e8f0;
        }

        .copyright {
            text-align: center;
            padding: 20px;
            color: #64748b;
            font-size: 12px;
        }

        .empty-row {
            text-align: center;
            padding: 35px;
            color: #94a3b8;
        }

        @media(max-width:600px) {
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
            <h1>Daftar Alat Bengkel</h1>
            <p>Pilih alat yang ingin Anda pinjam.</p>
        </div>

        <a href="{{ route('user.riwayat') }}" class="btn">
            Riwayat Peminjaman →
        </a>
    </div>

    @if(session('success'))
        <div class="message success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="message error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="message error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">

        <div class="card-heading">
            <h3>Inventaris Alat Bengkel</h3>
            <span class="total">{{ $alats->count() }} Jenis Alat</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Stok Tersedia</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Peminjaman</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($alats as $alat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="alat-name">
                                    {{ $alat->nama_alat }}
                                </span>
                            </td>

                            <td>
                                {{ $alat->kategori->nama_kategori ?? '-' }}
                            </td>

                            <td>
                                @if($alat->stok > 0)
                                    <span class="stock">
                                        {{ $alat->stok }} unit
                                    </span>
                                @else
                                    <span class="stock empty-stock">
                                        Stok Habis
                                    </span>
                                @endif
                            </td>

                            <td>
                                @php
                                    $kondisiClass = match($alat->kondisi) {
                                        'Baik' => 'condition-baik',
                                        'Rusak Ringan' => 'condition-ringan',
                                        'Rusak Berat' => 'condition-berat',
                                        default => '',
                                    };
                                @endphp

                                <span class="condition {{ $kondisiClass }}">
                                    {{ $alat->kondisi ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="location">
                                    {{ $alat->lokasi ?: '-' }}
                                </span>
                            </td>

                            <td>{{ $alat->keterangan ?: '-' }}</td>

                            <td>
                                @if($alat->stok > 0)
                                    <form
                                        action="{{ route('user.peminjaman.pinjam', ['alat' => $alat->id_alat]) }}"
                                        method="POST"
                                        autocomplete="off"
                                        class="form-pinjam"
                                    >
                                        @csrf

                                        <input
                                            type="number"
                                            name="jumlah"
                                            min="1"
                                            max="{{ $alat->stok }}"
                                            value="1"
                                            required
                                            autocomplete="off"
                                        >

                                        <button type="submit" class="btn">
                                            Pinjam
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-disabled" disabled>
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-row">
                                Belum ada alat yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
            ← Kembali ke Dashboard
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary">
                Logout
            </button>
        </form>
    </div>

</main>

<footer class="copyright">
    © {{ date('Y') }} BENGKEL ALAT ALVINO. All Rights Reserved.
</footer>

</body>
</html>
