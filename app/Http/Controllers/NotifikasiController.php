<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    // Tandai satu notifikasi sebagai sudah dibaca.
    public function baca(Request $request, string $id)
    {
        $notifikasi = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notifikasi->markAsRead();

        $url = $notifikasi->data['url'] ?? null;

        // Hanya izinkan URL internal aplikasi.
        if ($url && str_starts_with($url, url('/'))) {
            return redirect($url);
        }

        return back()->with('success', 'Notifikasi telah dibaca.');
    }

    // Tandai seluruh notifikasi sebagai sudah dibaca.
    public function bacaSemua(Request $request)
    {
        $request->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        return back()->with(
            'success',
            'Semua notifikasi berhasil ditandai sudah dibaca.'
        );
    }
}
