<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogActivityMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Simpan pengguna sebelum request diproses.
        $userSebelum = Auth::user();

        $response = $next($request);

        // Ambil pengguna setelah request diproses.
        $userSesudah = Auth::user();

        $routeName = $request->route()?->getName();
        $method = $request->method();

        // Hanya catat aktivitas yang mengubah data.
        $allowedMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];

        if (!in_array($method, $allowedMethods)) {
            return $response;
        }

        // Daftar aktivitas yang dicatat.
        $aktivitas = [

            // AUTH
            'login.process' => [
                'login',
                'Pengguna berhasil login.'
            ],

            'logout' => [
                'logout',
                'Pengguna melakukan logout.'
            ],

            // ADMIN - USER
            'admin.users.store' => [
                'create',
                'Admin menambahkan akun pengguna.'
            ],

            'admin.users.update' => [
                'update',
                'Admin memperbarui akun pengguna.'
            ],

            'admin.users.destroy' => [
                'delete',
                'Admin menghapus akun pengguna.'
            ],

            // ADMIN - KATEGORI
            'admin.kategori.store' => [
                'create',
                'Admin menambahkan kategori alat.'
            ],

            'admin.kategori.update' => [
                'update',
                'Admin memperbarui kategori alat.'
            ],

            'admin.kategori.destroy' => [
                'delete',
                'Admin menghapus kategori alat.'
            ],

            // ADMIN - ALAT
            'admin.alat.store' => [
                'create',
                'Admin menambahkan data alat.'
            ],

            'admin.alat.update' => [
                'update',
                'Admin memperbarui data alat.'
            ],

            'admin.alat.destroy' => [
                'delete',
                'Admin menghapus data alat.'
            ],

            // ADMIN - PEMINJAMAN
            'admin.peminjaman.store' => [
                'create',
                'Admin menambahkan data peminjaman.'
            ],

            'admin.peminjaman.update' => [
                'update',
                'Admin memperbarui data peminjaman.'
            ],

            'admin.peminjaman.destroy' => [
                'delete',
                'Admin menghapus data peminjaman.'
            ],

            // ADMIN - PENGEMBALIAN
            'admin.pengembalian.store' => [
                'create',
                'Admin menambahkan data pengembalian.'
            ],

            'admin.pengembalian.update' => [
                'update',
                'Admin memperbarui data pengembalian.'
            ],

            'admin.pengembalian.destroy' => [
                'delete',
                'Admin menghapus data pengembalian.'
            ],

            // PETUGAS - PEMINJAMAN
            'petugas.peminjaman.setujui' => [
                'approve',
                'Petugas menyetujui pengajuan peminjaman.'
            ],

            'petugas.peminjaman.tolak' => [
                'reject',
                'Petugas menolak pengajuan peminjaman.'
            ],

            // PETUGAS - PENGEMBALIAN
            'petugas.pengembalian.proses' => [
                'return',
                'Petugas memproses pengembalian alat.'
            ],

            // USER
            'user.peminjaman.pinjam' => [
                'borrow',
                'User mengajukan peminjaman alat.'
            ],

            'user.pengembalian.ajukan' => [
                'return_request',
                'User mengajukan pengembalian alat.'
            ],
        ];

        // Abaikan route yang tidak termasuk daftar aktivitas.
        if (!$routeName || !isset($aktivitas[$routeName])) {
            return $response;
        }

        // Jangan catat request yang menghasilkan error HTTP.
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        // Jangan catat request yang gagal validasi.
        if ($request->hasSession() && $request->session()->has('errors')) {
            return $response;
        }

        // Jangan catat login yang gagal.
        if ($routeName === 'login.process' && !$userSesudah) {
            return $response;
        }

        // Gunakan pengguna sebelum request, atau sesudah login.
        $user = $userSebelum ?? $userSesudah;

        if (!$user) {
            return $response;
        }

        // Simpan catatan aktivitas.
        try {
            ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'action' => $aktivitas[$routeName][0],
                'description' => $aktivitas[$routeName][1],
                'route_name' => $routeName,
                'method' => $method,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Kegagalan pencatatan tidak boleh mengganggu aplikasi.
            report($e);
        }

        return $response;
    }
}
