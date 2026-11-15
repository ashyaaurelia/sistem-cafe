<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;
use App\Models\Bahan;

class Resep extends Model
{
    protected $fillable = [
        'menu_id',
        'bahan_id',
        'jumlah',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }
}
