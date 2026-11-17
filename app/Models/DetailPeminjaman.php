<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjamen';

    protected $fillable = [
        'id_pinjam',
        'id_alat',
        'jumlah',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'id_pinjam', 'id_pinjam');
    }

    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }
}