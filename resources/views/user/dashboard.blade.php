
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - BENGKEL ALAT ALVINO</title>

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
            box-shadow: 0 4px 15px rgba(15,35,75,.15);
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
            display: flex;
            align-items: center;
            justify-content: center;
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

        .brand h2 {
            margin: 0;
            font-size: 19px;
            letter-spacing: .5px;
        }

        .brand small {
            color: #bfdbfe;
            font-size: 10px;
            letter-spacing: 2px;
        }

        .user-info {
            background: rgba(255,255,255,.1);
            padding: 10px 17px;
            border-radius: 10px;
            font-size: 13px;
        }

        .container {
            max-width: 1150px;
            margin: 35px auto;
            padding: 0 22px;
        }

        .welcome {
            background: linear-gradient(120deg,#102a56,#2563eb);
            padding: 38px;
            border-radius: 18px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(37,99,235,.17);
        }

        .welcome:after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border: 35px solid rgba(255,255,255,.08);
            border-radius: 50%;
            right: -50px;
            top: -90px;
        }

        .welcome h1 {
            margin: 0 0 12px;
            font-size: 30px;
        }

        .welcome p {
            line-height: 1.8;
            color: #dbeafe;
            max-width: 600px;
            margin-bottom: 20px;
        }

        .role {
            display: inline-block;
            background: rgba(255,255,255,.17);
            border: 1px solid rgba(255,255,255,.25);
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .section-title {
            margin: 35px 0 18px;
            font-size: 21px;
            color: #102a56;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2,1fr);
            gap: 22px;
        }

        .menu-card {
            background: white;
            padding: 28px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(15,35,75,.04);
            transition: .25s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(37,99,235,.10);
        }

        .menu-icon {
            width: 52px;
            height: 52px;
            border-radius: 13px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }

        .menu-icon svg {
            width: 27px;
            height: 27px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .menu-card h3 {
            margin: 0 0 10px;
            font-size: 19px;
            color: #102a56;
        }

        .menu-card p {
            color: #64748b;
            line-height: 1.8;
            min-height: 55px;
            font-size: 14px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 19px;
            border-radius: 9px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        .btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .info-box {
            margin-top: 25px;
            padding: 23px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 14px;
            line-height: 2;
            color: #334155;
            font-size: 14px;
        }

        .info-box strong {
            color: #102a56;
            font-size: 16px;
        }

        .footer {
            margin-top: 35px;
            padding: 22px 0;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .footer span {
            color: #64748b;
            font-size: 13px;
        }

        .btn-logout {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-logout:hover {
            background: #fecaca;
        }

        @media(max-width:650px) {
            .menu-grid { grid-template-columns: 1fr; }
            .welcome { padding: 25px; }
            .welcome h1 { font-size: 24px; }
            .navbar { padding: 15px 20px; }
            .footer { align-items: flex-start; flex-direction: column; }
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

    <section class="welcome">
        <h1>Selamat Datang, {{ auth()->user()->name }}!</h1>
        <p>
            Selamat datang di sistem peminjaman alat Bengkel TSM.
            Silakan gunakan layanan kami untuk meminjam alat bengkel
            dan memantau transaksi peminjaman Anda.
        </p>
        <span class="role">PENGGUNA / USER</span>
    </section>

    <h2 class="section-title">Layanan Pengguna</h2>

    <div class="menu-grid">

        <div class="menu-card">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M14.7 6.3a5 5 0 0 0-6.4 6.4L3 18l3 3 5.3-5.3a5 5 0 0 0 6.4-6.4L14 13l-3-3z"/>
                </svg>
            </div>

            <h3>Pinjam Alat</h3>
            <p>
                Lihat daftar alat bengkel, periksa stok yang tersedia,
                dan ajukan peminjaman alat sesuai kebutuhan.
            </p>

            <a href="{{ route('user.peminjaman.index') }}" class="btn">
                Lihat Daftar Alat →
            </a>
        </div>

        <div class="menu-card">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M8 2v4M16 2v4M3 10h18"/>
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="m9 16 2 2 4-4"/>
                </svg>
            </div>

            <h3>Riwayat Peminjaman</h3>
            <p>
                Pantau status pengajuan, tanggal peminjaman,
                pengembalian, serta informasi denda keterlambatan.
            </p>

            <a href="{{ route('user.riwayat') }}" class="btn">
                Lihat Riwayat →
            </a>
        </div>

    </div>

    <div class="info-box">
        <strong>Informasi Peminjaman</strong><br>
        1. Masa peminjaman alat adalah 1 hari.<br>
        2. Denda keterlambatan sebesar Rp1.000 per hari.<br>
        3. Pastikan alat dikembalikan dalam kondisi baik.<br>
        4. Periksa riwayat peminjaman untuk melihat status transaksi.
    </div>

    <footer class="footer">
        <span>© {{ date('Y') }} BENGKEL ALAT ALVINO</span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-logout">
                Logout
            </button>
        </form>
    </footer>

</main>

</body>
</html>
