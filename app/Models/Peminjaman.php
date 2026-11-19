<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'peminjamen';

    protected $primaryKey = 'id_pinjam';

    protected $fillable = [
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'denda',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'denda' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function detailPeminjamans(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_pinjam', 'id_pinjam');
    }

    public function pengembalians(): HasMany
    {
        return $this->hasMany(Pengembalian::class, 'id_pinjam', 'id_pinjam');
    }

    public function hitungDenda(?Carbon $tanggalPengembalian = null): int
    {
        if (!$this->tanggal_kembali) {
            return 0;
        }

        $batasPengembalian = Carbon::parse(
            $this->tanggal_kembali->toDateString(),
            'Asia/Jakarta'
        )->startOfDay();

        $tanggalAktual = ($tanggalPengembalian ?? Carbon::now('Asia/Jakarta'))
            ->copy()
            ->setTimezone('Asia/Jakarta')
            ->startOfDay();

        if ($tanggalAktual->lessThanOrEqualTo($batasPengembalian)) {
            return 0;
        }

        $hariTerlambat = (int) $batasPengembalian->diffInDays($tanggalAktual);

        return $hariTerlambat * 1000;
    }
}