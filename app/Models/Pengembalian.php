<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengembalian extends Model
{
    protected $table = 'pengembalians';

    protected $primaryKey = 'id_kembali';

    protected $fillable = [
        'id_pinjam',
        'tanggal_kembali',
        'kondisi_alat',
        'denda',
        'diterima_oleh',
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
        'denda' => 'decimal:2',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(
            Peminjaman::class,
            'id_pinjam',
            'id_pinjam'
        );
    }
}
