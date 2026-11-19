<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'nomor_transaksi',
        'tanggal',
        'subtotal',
        'biaya_layanan',
        'pajak',
        'total',
        'metode_pembayaran',
        'status',
    ];
    public function detailTransaksis(){
        return $this->hasMany(DetailTransaksi::class);
    }
}