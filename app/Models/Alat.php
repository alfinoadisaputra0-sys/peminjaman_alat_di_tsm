<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alats';

    protected $primaryKey = 'id_alat';

    protected $fillable = [
        'kategori_id',
        'nama_alat',
        'stok',
        'kondisi',
        'lokasi',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(
            Kategori::class,
            'kategori_id',
            'id_kategori'
        );
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(
            DetailPeminjaman::class,
            'id_alat',
            'id_alat'
        );
    }
}
