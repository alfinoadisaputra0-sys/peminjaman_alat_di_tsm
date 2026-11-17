
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard Petugas') - BENGKEL ALAT ALVINO</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f8ff;
            color: #263247;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: #102a56;
            color: white;
            padding: 20px 15px;
            overflow-y: auto;
            z-index: 1000;
        }

        /* LOGO */
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 5px 22px;
            border-bottom: 1px solid #354d72;
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
            font-size: 15px;
            font-weight: 750;
            letter-spacing: .3px;
            white-space: nowrap;
        }

        .brand-text span {
            display: block;
            color: #bfdbfe;
            font-size: 8px;
            letter-spacing: 1.3px;
            margin-top: 6px;
            white-space: nowrap;
        }

        /* MENU */
        .menu-title {
            color: #93b4e2;
            font-size: 11px;
            font-weight: 700;
            margin: 25px 12px 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu a {
            display: block;
            color: #dbeafe;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 9px;
            margin-bottom: 6px;
            font-size: 14px;
            transition: .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: #2563eb;
            color: white;
        }

        .menu a.active {
            font-weight: 700;
        }

        /* LOGOUT */
        .logout {
            width: 100%;
            border: 1px solid rgba(255,255,255,.15);
            background: #dc2626;
            color: white;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        .logout:hover {
            background: #b91c1c;
        }

        /* MAIN */
        .main {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            background: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            box-shadow: 0 2px 10px rgba(15,35,75,.05);
            border-bottom: 1px solid #e2e8f0;
        }

        .topbar h2 {
            font-size: 21px;
            color: #102a56;
            font-weight: 700;
        }

        .user-info {
            font-size: 14px;
            color: #64748b;
        }

        .user-info strong {
            color: #1d4ed8;
        }

        /* NOTIFIKASI */
        .notification-menu {
            position: relative;
            display: inline-block;
        }

        .notification-toggle {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            background: #ffffff;
            color: #102a56;
            cursor: pointer;
            font-size: 21px;
            list-style: none;
        }

        .notification-toggle::-webkit-details-marker {
            display: none;
        }

        .notification-count {
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 19px;
            height: 19px;
            padding: 0 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            background: #dc2626;
            color: white;
            font-size: 10px;
            font-weight: 700;
        }

        .notification-dropdown {
            position: absolute;
            top: 52px;
            right: 0;
            width: 340px;
            max-width: calc(100vw - 30px);
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(15,35,75,.16);
            z-index: 2000;
            overflow: hidden;
            color: #172554;
        }

        .notification-header {
            padding: 14px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .notification-header strong {
            font-size: 14px;
        }

        .notification-header form {
            margin: 0;
        }

        .notification-header button {
            border: 0;
            background: transparent;
            color: #2563eb;
            font-size: 11px;
            cursor: pointer;
        }

        .notification-item {
            display: block;
            width: 100%;
            padding: 13px 16px;
            text-align: left;
            border: 0;
            border-bottom: 1px solid #f1f5f9;
            background: white;
            cursor: pointer;
            color: #334155;
        }

        .notification-item:hover {
            background: #f1f5f9;
        }

        .notification-item.unread {
            background: #eff6ff;
        }

        .notification-item strong {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            color: #102a56;
        }

        .notification-item span {
            display: block;
            font-size: 12px;
            line-height: 1.5;
            color: #64748b;
        }

        .notification-empty {
            padding: 25px 15px;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
        }

        .notification-footer {
            padding: 10px;
            text-align: center;
            color: #64748b;
            font-size: 11px;
        }

        /* CONTENT */
        .content {
            padding: 30px;
            min-height: calc(100vh - 130px);
        }

        /* FOOTER */
        .app-footer {
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 13px;
        }

        .app-footer p {
            margin: 0;
        }

        /* RESPONSIVE */
        @media(max-width: 900px) {
            .sidebar {
                width: 220px;
            }

            .main {
                margin-left: 220px;
            }

            .content {
                padding: 20px;
            }

            .topbar {
                padding: 18px 20px;
            }
        }

        @media(max-width: 600px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 15px;
            }

            .brand {
                padding-bottom: 15px;
            }

            .menu-title {
                margin-top: 18px;
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                padding: 16px;
            }

            .topbar h2 {
                font-size: 18px;
            }

            .content {
                padding: 15px;
            }

            .notification-dropdown {
                right: -5px;
                width: 300px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <!-- LOGO BENGKEL ALAT ALVINO -->
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

        <!-- MENU PETUGAS -->
        <div class="menu">

            <div class="menu-title">
                Menu Utama
            </div>

            <a href="{{ route('petugas.dashboard') }}"
               class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('petugas.peminjaman.index') }}"
               class="{{ request()->routeIs('petugas.peminjaman.*') ? 'active' : '' }}">
                Pengajuan Peminjaman
            </a>

            <a href="{{ route('petugas.pengembalian.index') }}"
               class="{{ request()->routeIs('petugas.pengembalian.*') ? 'active' : '' }}">
                Pengembalian
            </a>

            <a href="{{ route('petugas.transaksi.index') }}"
               class="{{ request()->routeIs('petugas.transaksi.*') ? 'active' : '' }}">
                Data Transaksi
            </a>

            <a href="{{ route('petugas.laporan.index') }}"
               class="{{ request()->routeIs('petugas.laporan.*') ? 'active' : '' }}">
                Laporan
            </a>

            <div class="menu-title">
                Akun
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout">
                    Logout
                </button>
            </form>

        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">

        <header class="topbar">

            <h2>@yield('page-title', 'Dashboard Petugas')</h2>

            <!-- NOTIFIKASI DAN INFORMASI PETUGAS -->
            <div style="display:flex; align-items:center; gap:18px;">

                @php
                    $notifikasiTerbaru = auth()->user()
                        ->notifications()
                        ->latest()
                        ->take(5)
                        ->get();

                    $jumlahBelumDibaca = auth()->user()
                        ->unreadNotifications()
                        ->count();
                @endphp

                <details class="notification-menu">

                    <summary class="notification-toggle" title="Notifikasi">
                        🔔

                        @if($jumlahBelumDibaca > 0)
                            <span class="notification-count">
                                {{ $jumlahBelumDibaca > 99 ? '99+' : $jumlahBelumDibaca }}
                            </span>
                        @endif
                    </summary>

                    <div class="notification-dropdown">

                        <div class="notification-header">
                            <strong>Notifikasi Transaksi</strong>

                            @if($jumlahBelumDibaca > 0)
                                <form action="{{ route('notifikasi.baca.semua') }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit">Baca semua</button>
                                </form>
                            @endif
                        </div>

                        @forelse($notifikasiTerbaru as $notifikasi)

                            <form action="{{ route('notifikasi.baca', $notifikasi->id) }}"
                                  method="POST">
                                @csrf

                                <button type="submit"
                                        class="notification-item {{ $notifikasi->read_at ? '' : 'unread' }}">

                                    <strong>
                                        {{ $notifikasi->data['judul'] ?? 'Notifikasi' }}
                                    </strong>

                                    <span>
                                        {{ $notifikasi->data['pesan'] ?? '' }}
                                    </span>

                                    <span>
                                        {{ $notifikasi->created_at->diffForHumans() }}
                                    </span>

                                </button>
                            </form>

                        @empty

                            <div class="notification-empty">
                                Belum ada notifikasi.
                            </div>

                        @endforelse

                        <div class="notification-footer">
                            Menampilkan 5 notifikasi terbaru
                        </div>

                    </div>

                </details>

                <div class="user-info">
                    Petugas:
                    <strong>{{ auth()->user()->name }}</strong>
                </div>

            </div>

        </header>

        <section class="content">

            @yield('content')

        </section>

        <footer class="app-footer">
            <p>
                © {{ date('Y') }} BENGKEL ALAT ALVINO.
                By Alvino Adi Saputra.
            </p>
        </footer>

    </main>

    @stack('scripts')

</body>
</html>
