
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Panel Admin') - BENGKEL ALAT ALVINO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f8ff;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #172554;
        }

        /* HEADER */
        .navbar-admin {
            background: #102a56;
            min-height: 70px;
            padding: 10px 25px;
            box-shadow: 0 3px 12px rgba(15,35,75,.12);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0;
            margin: 0;
            text-decoration: none;
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
            stroke: #ffffff;
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
            margin: 0;
        }

        .brand-text span {
            display: block;
            color: #bfdbfe;
            font-size: 10px;
            letter-spacing: 2px;
            margin-top: 5px;
        }

        /* MENU */
        .navbar-admin .nav-link {
            color: #dbeafe !important;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 12px !important;
            border-radius: 7px;
            transition: .2s;
        }

        .navbar-admin .nav-link:hover {
            background: #1e40af;
            color: white !important;
        }

        .navbar-toggler {
            border-color: #647da8;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(191,219,254,.2);
        }

        /* CONTENT */
        .main-container {
            max-width: 1250px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .content-card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 5px 20px rgba(15,35,75,.04);
            min-height: 350px;
        }

        .page-title {
            font-weight: bold;
            color: #102a56;
            margin-bottom: 8px;
        }

        .table {
            vertical-align: middle;
        }

        /* BUTTON */
        .btn-primary {
            background: #2563eb;
            border-color: #2563eb;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
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
            user-select: none;
        }

        .notification-toggle::-webkit-details-marker {
            display: none;
        }

        .notification-toggle::marker {
            content: "";
        }

        .notification-toggle:hover {
            background: #eff6ff;
        }

        .notification-toggle:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 3px;
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

        /* Dropdown hanya muncul ketika details terbuka */
        .notification-menu:not([open]) .notification-dropdown {
            display: none;
        }

        .notification-menu[open] .notification-dropdown {
            display: block;
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

        .notification-header button:hover {
            color: #1d4ed8;
            text-decoration: underline;
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

        /* FOOTER */
        .app-footer {
            margin-top: 25px;
            padding: 18px 0;
            text-align: center;
            color: #64748b;
            font-size: 13px;
        }

        .app-footer p {
            margin: 0;
        }

        /* RESPONSIVE */
        @media(max-width: 991px) {
            .navbar-admin {
                padding: 12px 18px;
            }

            .navbar-nav {
                padding-top: 12px;
            }

            .navbar-admin .nav-link {
                padding: 10px !important;
            }

            .notification-dropdown {
                left: 0;
                right: auto;
            }
        }

        @media(max-width: 500px) {
            .brand-text h2 {
                font-size: 15px;
            }

            .brand-text span {
                font-size: 8px;
                letter-spacing: 1.5px;
            }

            .brand-icon {
                width: 40px;
                height: 40px;
                min-width: 40px;
            }

            .main-container {
                padding: 0 12px;
            }

            .content-card {
                padding: 16px;
            }

            .notification-dropdown {
                width: 300px;
                left: -5px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-admin">

    <div class="container-fluid px-lg-4">

        <!-- LOGO DAN NAMA APLIKASI -->
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">

            <div class="brand-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M14.7 6.3a5 5 0 0 0-6.4 6.4L3 18l3 3 5.3-5.3a5 5 0 0 0 6.4-6.4L14 13l-3-3z"/>
                </svg>
            </div>

            <div class="brand-text">
                <h2>BENGKEL ALAT ALVINO</h2>
                <span>SISTEM PEMINJAMAN ALAT</span>
            </div>

        </a>

        <!-- TOGGLE MOBILE -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuAdmin"
                aria-controls="menuAdmin"
                aria-expanded="false"
                aria-label="Buka menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- MENU ADMIN -->
        <div class="collapse navbar-collapse" id="menuAdmin">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        User
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.kategori.index') }}">
                        Kategori
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.alat.index') }}">
                        Alat
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.peminjaman.index') }}">
                        Peminjaman
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.pengembalian.index') }}">
                        Pengembalian
                    </a>
                </li>

                <!-- LOG AKTIVITAS -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.aktivitas.index') }}">
                        Log Aktivitas
                    </a>
                </li>

                <!-- NOTIFIKASI ADMIN -->
                <li class="nav-item me-lg-2 my-2 my-lg-0">

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

                    <details class="notification-menu" id="notificationMenu">

                        <summary
                            class="notification-toggle"
                            id="notificationToggle"
                            title="Notifikasi"
                            aria-label="Buka atau tutup notifikasi"
                            aria-expanded="false"
                        >
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

                                        <button type="submit">
                                            Baca semua
                                        </button>
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

                </li>

                <!-- LOGOUT -->
                <li class="nav-item">

                    <form action="{{ route('logout') }}"
                          method="POST"
                          class="ms-lg-2">

                        @csrf

                        <button type="submit" class="btn btn-danger btn-sm mt-1">
                            Logout
                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</nav>

<!-- HALAMAN ADMIN -->
<main class="main-container">

    <div class="content-card">

        @yield('content')

    </div>

    <footer class="app-footer">
        <p>
            © {{ date('Y') }} BENGKEL ALAT ALVINO.
            By Alvino Adi Saputra.
        </p>
    </footer>

</main>

<!-- BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JAVASCRIPT NOTIFIKASI -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const notificationMenu = document.getElementById('notificationMenu');
    const notificationToggle = document.getElementById('notificationToggle');

    // Pastikan elemen notifikasi tersedia
    if (!notificationMenu || !notificationToggle) {
        return;
    }

    // FUNGSI MEMBUKA NOTIFIKASI
    function bukaNotifikasi() {
        notificationMenu.open = true;
        notificationToggle.setAttribute('aria-expanded', 'true');
    }

    // FUNGSI MENUTUP NOTIFIKASI
    function tutupNotifikasi() {
        notificationMenu.open = false;
        notificationToggle.setAttribute('aria-expanded', 'false');
    }

    // KLIK LONCENG: BUKA / TUTUP
    notificationToggle.addEventListener('click', function (event) {

        // Mencegah perilaku bawaan details
        event.preventDefault();

        if (notificationMenu.open) {
            tutupNotifikasi();
        } else {
            bukaNotifikasi();
        }

    });

    // KLIK DI LUAR DROPDOWN: TUTUP
    document.addEventListener('click', function (event) {

        if (!notificationMenu.contains(event.target)) {
            tutupNotifikasi();
        }

    });

    // TEKAN ESCAPE: TUTUP
    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape' && notificationMenu.open) {
            tutupNotifikasi();
        }

    });

});
</script>

@stack('scripts')

</body>
</html>
