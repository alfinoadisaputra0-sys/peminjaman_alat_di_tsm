
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BENGKEL ALAT ALVINO</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            background: #f5f8ff;
            color: #172554;
        }

        /* HEADER */
        .navbar {
            background: #102a56;
            color: white;
            min-height: 70px;
            padding: 12px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            box-shadow: 0 4px 15px rgba(15,35,75,.12);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            min-width: 43px;
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

        .brand-text h2 {
            color: white;
            font-size: 19px;
            font-weight: 750;
            letter-spacing: .4px;
        }

        .brand-text span {
            display: block;
            color: #bfdbfe;
            font-size: 10px;
            letter-spacing: 2px;
            margin-top: 5px;
        }

        .admin-label {
            background: rgba(255,255,255,.1);
            color: #dbeafe;
            padding: 10px 16px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
        }

        /* CONTAINER */
        .container {
            width: 94%;
            max-width: 1250px;
            margin: 32px auto;
        }

        /* WELCOME */
        .welcome {
            background: linear-gradient(120deg,#102a56,#2563eb);
            padding: 35px;
            border-radius: 17px;
            margin-bottom: 28px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(37,99,235,.13);
        }

        .welcome::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border: 35px solid rgba(255,255,255,.08);
            border-radius: 50%;
            right: -55px;
            top: -100px;
        }

        .welcome h1 {
            font-size: 28px;
            margin-bottom: 12px;
        }

        .welcome p {
            color: #dbeafe;
            line-height: 1.8;
            font-size: 14px;
            max-width: 700px;
        }

        .role {
            display: inline-block;
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.2);
            color: white;
            padding: 8px 15px;
            border-radius: 30px;
            margin-top: 18px;
            font-size: 12px;
            font-weight: bold;
        }

        /* SECTION */
        .section-title {
            margin: 32px 0 18px;
            font-size: 21px;
            color: #102a56;
            font-weight: 700;
        }

        /* STATISTICS */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 17px;
        }

        .stat-card {
            background: white;
            padding: 22px;
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

        .stat-card p {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 13px;
            font-weight: 500;
        }

        .stat-card h2 {
            font-size: 29px;
            color: #2563eb;
            font-weight: 750;
        }

        /* MENU */
        .menus {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .menu-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 24px;
            transition: .25s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(37,99,235,.09);
            border-color: #bfdbfe;
        }

        .menu-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 17px;
        }

        .menu-icon svg {
            width: 26px;
            height: 26px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .menu-card h3 {
            margin-bottom: 10px;
            font-size: 17px;
            color: #102a56;
        }

        .menu-card p {
            color: #64748b;
            font-size: 13px;
            line-height: 1.8;
            min-height: 65px;
            margin-bottom: 17px;
        }

        .menu-card a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            background: #2563eb;
            color: white;
            padding: 11px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }

        .menu-card a:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        /* FOOTER */
        .footer {
            margin-top: 35px;
            padding: 20px 0;
            border-top: 1px solid #dbe2ea;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            color: #64748b;
            font-size: 13px;
        }

        .logout {
            background: #fee2e2;
            color: #b91c1c;
            border: none;
            padding: 11px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }

        .logout:hover {
            background: #fecaca;
        }

        /* RESPONSIVE */
        @media(max-width: 900px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .menus {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 600px) {
            .navbar {
                padding: 14px 18px;
            }

            .brand-text h2 {
                font-size: 15px;
            }

            .brand-text span {
                font-size: 8px;
                letter-spacing: 1.5px;
            }

            .container {
                width: 92%;
            }

            .welcome {
                padding: 25px;
            }

            .welcome h1 {
                font-size: 23px;
            }

            .stats, .menus {
                grid-template-columns: 1fr;
            }

            .footer {
                flex-direction: column;
                align-items: flex-start;
            }
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

        <div class="brand-text">
            <h2>BENGKEL ALAT ALVINO</h2>
            <span>SISTEM PEMINJAMAN ALAT</span>
        </div>
    </div>

    <div class="admin-label">
        Panel Administrator
    </div>

</header>

<main class="container">

    <section class="welcome">
        <h1>Selamat Datang, {{ auth()->user()->name }}!</h1>

        <p>
            Kelola data pengguna, kategori, alat, peminjaman,
            dan pengembalian alat bengkel melalui dashboard ini.
        </p>

        <span class="role">ROLE: ADMIN</span>
    </section>

    <h2 class="section-title">Ringkasan Data</h2>

    <section class="stats">

        <div class="stat-card">
            <p>Total User</p>
            <h2>{{ $jumlahUser }}</h2>
        </div>

        <div class="stat-card">
            <p>Total Petugas</p>
            <h2>{{ $jumlahPetugas }}</h2>
        </div>

        <div class="stat-card">
            <p>Total Alat</p>
            <h2>{{ $jumlahAlat }}</h2>
        </div>

        <div class="stat-card">
            <p>Total Kategori</p>
            <h2>{{ $jumlahKategori }}</h2>
        </div>

        <div class="stat-card">
            <p>Total Peminjaman</p>
            <h2>{{ $jumlahPeminjaman }}</h2>
        </div>

        <div class="stat-card">
            <p>Peminjaman Menunggu</p>
            <h2>{{ $peminjamanMenunggu }}</h2>
        </div>

        <div class="stat-card">
            <p>Peminjaman Disetujui</p>
            <h2>{{ $peminjamanDisetujui }}</h2>
        </div>

        <div class="stat-card">
            <p>Total Pengembalian</p>
            <h2>{{ $jumlahPengembalian }}</h2>
        </div>

    </section>

    <h2 class="section-title">Menu Administrator</h2>

    <section class="menus">

        <div class="menu-card">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="10" cy="7" r="4"/>
                    <path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <h3>Data User</h3>
            <p>Tambah, lihat, edit, dan hapus akun User serta Petugas.</p>
            <a href="{{ route('admin.users.index') }}">Kelola User →</a>
        </div>

        <div class="menu-card">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                    <circle cx="8" cy="6" r="2"/>
                    <circle cx="16" cy="12" r="2"/>
                    <circle cx="10" cy="18" r="2"/>
                </svg>
            </div>
            <h3>Data Kategori</h3>
            <p>Kelola kategori alat bengkel dan pengelompokan alat.</p>
            <a href="{{ route('admin.kategori.index') }}">Kelola Kategori →</a>
        </div>

        <div class="menu-card">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M14.7 6.3a5 5 0 0 0-6.4 6.4L3 18l3 3 5.3-5.3a5 5 0 0 0 6.4-6.4L14 13l-3-3z"/>
                </svg>
            </div>
            <h3>Data Alat</h3>
            <p>Tambah alat, lihat stok, edit informasi, dan hapus data alat.</p>
            <a href="{{ route('admin.alat.index') }}">Kelola Alat →</a>
        </div>

        <div class="menu-card">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M8 2v4M16 2v4M3 10h18"/>
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M8 14h3M8 17h6"/>
                </svg>
            </div>
            <h3>Data Peminjaman</h3>
            <p>Tambah, lihat, edit, dan kelola data transaksi peminjaman.</p>
            <a href="{{ route('admin.peminjaman.index') }}">Kelola Peminjaman →</a>
        </div>

        <div class="menu-card">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M3 7h18v13H3z"/>
                    <path d="M7 7V4h10v3M8 12h8M8 16h5"/>
                    <path d="m15 3 2 2 2-2"/>
                </svg>
            </div>
            <h3>Data Pengembalian</h3>
            <p>Lihat dan kelola catatan pengembalian alat bengkel.</p>
            <a href="{{ route('admin.pengembalian.index') }}">Kelola Pengembalian →</a>
        </div>

        <!-- MENU LOG AKTIVITAS -->
        <div class="menu-card">

        <div class="menu-icon">
            <svg viewBox="0 0 24 24">
                <path d="M3 3v18h18"/>
                <path d="m7 14 4-4 4 4 6-7"/>
                <path d="M17 7h4v4"/>
            </svg>
        </div>

        <h3>Log Aktivitas</h3>

        <p>
            Melihat dan memantau seluruh aktivitas Admin,
            Petugas, dan User dalam sistem peminjaman alat.
        </p>

        <a href="{{ route('admin.aktivitas.index') }}">
            Lihat Aktivitas →
        </a>

        </div>

    </section>

    <footer class="footer">

        <span>
            © {{ date('Y') }} BENGKEL ALAT ALVINO
        </span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>

    </footer>

</main>

</body>
</html>
