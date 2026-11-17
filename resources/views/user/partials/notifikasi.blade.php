
<style>
    .user-navbar-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notif-wrapper {
        position: relative;
    }

    .notif-dropdown {
        position: relative;
    }

    .notif-dropdown summary {
        list-style: none;
        cursor: pointer;
        width: 43px;
        height: 43px;
        border-radius: 10px;
        background: rgba(255,255,255,.12);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: .2s;
    }

    .notif-dropdown summary::-webkit-details-marker {
        display: none;
    }

    .notif-dropdown summary:hover {
        background: rgba(255,255,255,.22);
    }

    .notif-dropdown summary svg {
        width: 23px;
        height: 23px;
        stroke: white;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .notif-count {
        position: absolute;
        top: -5px;
        right: -5px;
        min-width: 19px;
        height: 19px;
        padding: 0 5px;
        border-radius: 20px;
        background: #ef4444;
        color: white;
        font-size: 10px;
        font-weight: 700;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 2px solid #102a56;
    }

    .notif-panel {
        position: absolute;
        top: 55px;
        right: 0;
        width: 340px;
        max-width: calc(100vw - 30px);
        background: white;
        color: #172554;
        border-radius: 13px;
        box-shadow: 0 12px 35px rgba(0,0,0,.18);
        border: 1px solid #e2e8f0;
        z-index: 9999;
        overflow: hidden;
    }

    .notif-header {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .notif-header strong {
        font-size: 14px;
        color: #102a56;
    }

    .notif-header form {
        margin: 0;
    }

    .notif-read-all {
        border: none;
        background: none;
        color: #2563eb;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }

    .notif-list {
        max-height: 330px;
        overflow-y: auto;
    }

    .notif-item {
        padding: 13px 15px;
        border-bottom: 1px solid #f1f5f9;
        display: block;
    }

    .notif-item.unread {
        background: #eff6ff;
    }

    .notif-item form {
        margin: 0;
    }

    .notif-link {
        width: 100%;
        border: none;
        background: transparent;
        text-align: left;
        padding: 0;
        cursor: pointer;
        display: block;
    }

    .notif-link strong {
        display: block;
        color: #102a56;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .notif-link span {
        display: block;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .notif-link small {
        display: block;
        color: #94a3b8;
        font-size: 10px;
        margin-top: 7px;
    }

    .notif-empty {
        padding: 25px 15px;
        text-align: center;
        color: #94a3b8;
        font-size: 12px;
    }

    @media(max-width: 450px) {
        .notif-panel {
            right: -65px;
        }
    }
</style>

<div class="notif-wrapper">
    @php
        $userNotifikasi = auth()->user();
        $daftarNotifikasi = $userNotifikasi->notifications()->latest()->take(5)->get();
        $jumlahNotifikasi = $userNotifikasi->unreadNotifications()->count();
    @endphp

    <details class="notif-dropdown">
        <summary title="Notifikasi">
            <svg viewBox="0 0 24 24">
                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                <path d="M10 21h4"/>
            </svg>

            @if($jumlahNotifikasi > 0)
                <span class="notif-count">
                    {{ $jumlahNotifikasi > 99 ? '99+' : $jumlahNotifikasi }}
                </span>
            @endif
        </summary>

        <div class="notif-panel">
            <div class="notif-header">
                <strong>Notifikasi</strong>

                @if($jumlahNotifikasi > 0)
                    <form action="{{ route('notifikasi.baca.semua') }}" method="POST">
                        @csrf
                        <button type="submit" class="notif-read-all">
                            Baca semua
                        </button>
                    </form>
                @endif
            </div>

            <div class="notif-list">
                @forelse($daftarNotifikasi as $notifikasi)
                    <div class="notif-item {{ $notifikasi->read_at ? '' : 'unread' }}">
                        <form
                            action="{{ route('notifikasi.baca', $notifikasi->id) }}"
                            method="POST"
                        >
                            @csrf

                            <button type="submit" class="notif-link">
                                <strong>
                                    {{ $notifikasi->data['judul'] ?? 'Notifikasi Transaksi' }}
                                </strong>

                                <span>
                                    {{ $notifikasi->data['pesan'] ?? 'Ada informasi transaksi baru.' }}
                                </span>

                                <small>
                                    {{ $notifikasi->created_at->diffForHumans() }}
                                    @if(!$notifikasi->read_at)
                                        · Belum dibaca
                                    @else
                                        · Sudah dibaca
                                    @endif
                                </small>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="notif-empty">
                        <div style="font-size:25px;margin-bottom:8px;">🔔</div>
                        Belum ada notifikasi.
                    </div>
                @endforelse
            </div>
        </div>
    </details>
</div>
