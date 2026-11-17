<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    protected $fillable = [
        'tanggal',
        'bahan_id',
        'jumlah',
    ];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }
}
