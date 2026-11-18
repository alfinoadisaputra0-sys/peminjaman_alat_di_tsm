
@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')

<style>
    .activity-heading {
        color: #102a56;
        font-weight: 750;
    }

    .activity-card {
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        background: #fff;
        height: 100%;
        box-shadow: 0 4px 14px rgba(15, 35, 75, .04);
    }

    .activity-number {
        font-size: 28px;
        font-weight: 800;
        color: #102a56;
    }

    .activity-label {
        color: #64748b;
        font-size: 13px;
    }

    .activity-table th {
        background: #f1f5f9;
        color: #334155;
        font-size: 12px;
        white-space: nowrap;
    }

    .activity-table td {
        font-size: 13px;
    }

    .activity-description {
        min-width: 230px;
        color: #64748b;
    }

    /* PERBAIKAN UKURAN ICON PAGINATION */
    .activity-pagination svg {
        width: 16px !important;
        height: 16px !important;
        max-width: 16px !important;
        max-height: 16px !important;
        display: inline-block;
    }

    /* Mencegah SVG melebar */
    .activity-pagination {
        overflow-x: auto;
    }

    .activity-pagination svg {
        flex-shrink: 0;
    }
</style>

<!-- JUDUL HALAMAN -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h2 class="page-title activity-heading mb-1">
            Log Aktivitas
        </h2>

        <p class="text-muted mb-0">
            Pantau seluruh aktivitas Admin, Petugas, dan User.
        </p>
    </div>

    <span class="badge bg-primary px-3 py-2">
        Khusus Admin
    </span>
</div>

<!-- STATISTIK -->
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="activity-card p-3">
            <div class="activity-label">Total Aktivitas</div>
            <div class="activity-number">
                {{ number_format($totalAktivitas) }}
            </div>
            <small class="text-muted">Seluruh catatan sistem</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="activity-card p-3">
            <div class="activity-label">Aktivitas Hari Ini</div>
            <div class="activity-number text-success">
                {{ number_format($aktivitasHariIni) }}
            </div>
            <small class="text-muted">Catatan pada hari ini</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="activity-card p-3">
            <div class="activity-label">Aktivitas Admin</div>
            <div class="activity-number text-primary">
                {{ number_format($totalAdmin) }}
            </div>
            <small class="text-muted">Tindakan Admin</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="activity-card p-3">
            <div class="activity-label">Aktivitas Petugas</div>
            <div class="activity-number text-warning">
                {{ number_format($totalPetugas) }}
            </div>
            <small class="text-muted">Tindakan Petugas</small>
        </div>
    </div>

</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="activity-card p-3">
            <div class="activity-label">Aktivitas User</div>
            <div class="activity-number text-info">
                {{ number_format($totalUser) }}
            </div>
            <small class="text-muted">Tindakan User</small>
        </div>
    </div>
</div>

<!-- FILTER PENCARIAN -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">

        <h5 class="fw-bold mb-3">
            <i class="bi bi-funnel"></i>
            Filter Aktivitas
        </h5>

        <form action="{{ route('admin.aktivitas.index') }}" method="GET">

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Cari Pengguna atau Aktivitas
                    </label>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Masukkan nama atau keterangan..."
                    >
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        Role
                    </label>

                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>

                        <option value="admin" @selected(request('role') == 'admin')>
                            Admin
                        </option>

                        <option value="petugas" @selected(request('role') == 'petugas')>
                            Petugas
                        </option>

                        <option value="user" @selected(request('role') == 'user')>
                            User
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        Jenis Aktivitas
                    </label>

                    <select name="action" class="form-select">
                        <option value="">Semua Aktivitas</option>

                        @foreach([
                            'login',
                            'logout',
                            'create',
                            'update',
                            'delete',
                            'approve',
                            'reject',
                            'return',
                            'borrow',
                            'return_request'
                        ] as $aksi)

                            <option
                                value="{{ $aksi }}"
                                @selected(request('action') == $aksi)
                            >
                                {{ ucfirst(str_replace('_', ' ', $aksi)) }}
                            </option>

                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        Tanggal Awal
                    </label>

                    <input
                        type="date"
                        name="tanggal_awal"
                        class="form-control"
                        value="{{ request('tanggal_awal') }}"
                    >
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        Tanggal Akhir
                    </label>

                    <input
                        type="date"
                        name="tanggal_akhir"
                        class="form-control"
                        value="{{ request('tanggal_akhir') }}"
                    >
                </div>

                <div class="col-12 d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        Cari Aktivitas
                    </button>

                    <a
                        href="{{ route('admin.aktivitas.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>
</div>

<!-- TABEL AKTIVITAS -->
<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

            <h5 class="fw-bold mb-0">
                Riwayat Aktivitas Sistem
            </h5>

            <span class="badge bg-secondary">
                {{ $aktivitas->total() }} Catatan
            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-hover activity-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>Keterangan</th>
                        <th>Waktu</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($aktivitas as $log)

                        <tr>

                            <td>
                                {{ $aktivitas->firstItem() + $loop->index }}
                            </td>

                            <td class="fw-semibold">
                                {{ $log->user_name }}
                            </td>

                            <td>
                                @if($log->user_role == 'admin')
                                    <span class="badge bg-primary">Admin</span>
                                @elseif($log->user_role == 'petugas')
                                    <span class="badge bg-warning text-dark">Petugas</span>
                                @else
                                    <span class="badge bg-success">User</span>
                                @endif
                            </td>

                            <td>
                                {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                            </td>

                            <td class="activity-description">
                                {{ $log->description }}
                            </td>

                            <td>
                                <div>
                                    {{ $log->created_at->format('d-m-Y') }}
                                </div>

                                <small class="text-muted">
                                    {{ $log->created_at->format('H:i:s') }}
                                </small>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="mb-2">
                                    <i class="bi bi-clipboard-x fs-1"></i>
                                </div>

                                Belum ada aktivitas yang tercatat.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- PAGINATION -->
        <div class="mt-3 activity-pagination">
            {{ $aktivitas->links() }}
        </div>

    </div>

</div>

@endsection
