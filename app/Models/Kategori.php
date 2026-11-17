<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relation\HasMany;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
    ];

    public function alats()
    {
        return $this->hasMany(Alat::class, 'kategori_id', 'id_kategori');
    }
}
