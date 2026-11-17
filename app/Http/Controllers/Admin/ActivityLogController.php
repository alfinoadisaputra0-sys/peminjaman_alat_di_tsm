<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
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

        // Filter berdasarkan tanggal awal.
        if ($request->filled('tanggal_awal')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->tanggal_awal
            );
        }

        // Filter berdasarkan tanggal akhir.
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->tanggal_akhir
            );
        }

        // Statistik seluruh aktivitas.
        $totalAktivitas = ActivityLog::count();

        $aktivitasHariIni = ActivityLog::whereDate(
            'created_at',
            today()
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

        // Ambil data aktivitas dengan pagination.
        $aktivitas = $query->paginate(15)->withQueryString();

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
