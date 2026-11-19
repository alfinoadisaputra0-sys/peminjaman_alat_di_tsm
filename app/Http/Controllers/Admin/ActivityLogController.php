<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'nullable|date_format:Y-m-d',
            'tanggal_akhir' => 'nullable|date_format:Y-m-d|after_or_equal:tanggal_awal',
            'role' => 'nullable|in:admin,petugas,user',
            'action' => 'nullable|string|max:50',
            'search' => 'nullable|string|max:100',
        ]);

        $query = ActivityLog::query()->latest();

        // Pencarian nama atau keterangan aktivitas.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan role.
        if ($request->filled('role')) {
            $query->where('user_role', $request->role);
        }

        // Filter berdasarkan jenis aktivitas.
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter tanggal awal WIB.
        if ($request->filled('tanggal_awal')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->tanggal_awal
            );
        }

        // Filter tanggal akhir WIB.
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->tanggal_akhir
            );
        }

        // Statistik.
        $totalAktivitas = ActivityLog::count();

        $hariIni = Carbon::now('Asia/Jakarta')->toDateString();

        $aktivitasHariIni = ActivityLog::whereDate(
            'created_at',
            $hariIni
        )->count();

        $totalAdmin = ActivityLog::where(
            'user_role',
            'admin'
        )->count();

        $totalPetugas = ActivityLog::where(
            'user_role',
            'petugas'
        )->count();

        $totalUser = ActivityLog::where(
            'user_role',
            'user'
        )->count();

        // Pagination.
        $aktivitas = $query
            ->paginate(15)
            ->withQueryString();

        return view('admin.aktivitas.index', compact(
            'aktivitas',
            'totalAktivitas',
            'aktivitasHariIni',
            'totalAdmin',
            'totalPetugas',
            'totalUser'
        ));
    }
}
