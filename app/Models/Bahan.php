<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'stok',
        'satuan',
        'stok_minimum',
        'harga',
        'harga_diperbarui_pada',
    ];

    public function reseps()
    {
        return $this->hasMany(Resep::class);
    }
}
