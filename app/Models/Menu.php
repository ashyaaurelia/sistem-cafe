<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'harga',
        'kategori',
    ];

    public function reseps()
    {
        return $this->hasMany(Resep::class);
    }
}
