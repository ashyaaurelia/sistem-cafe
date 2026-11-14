<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    protected $fillable = [
        'nama',
        'stok',
        'satuan',
        'stok_minimum',
    ];
}
