<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\Bahan;

class LaporanController extends Controller
{
    public function index()
    {
        // laporan penjualan menu
        $penjualan = DetailTransaksi::whereHas('transaksi', function ($query){
            $query->where('status', '!=', 'dibatalkan');
        })
        ->selectRaw('menu_id, nama_menu, SUM(jumlah) as total_terjual, SUM(subtotal) as total_penjualan')
        ->groupBy('menu_id', 'nama_menu')
        ->get();

        // laporan hpp dna margin per menu
        $menus = Menu::with('reseps.bahan')->get();

        foreach ($menus as $menu){
            $menu->hpp = 0;

            foreach ($menu->reseps as $resep){
                $menu->hpp += $resep->jumlah * $resep->bahan->harga;
            }
            $menu->margin = $menu->harga - $menu->hpp;
        }

        // laporan bahan menipis
        $bahansMenipis = Bahan::whereRaw(
            'CAST(stok AS DECIMAL(12,2)) <= CAST(stok_minimum AS DECIMAL(12,2))'
        )->get();

        return view('manajer.laporan.penjualan', compact(
            'penjualan', 
            'menus', 
            'bahansMenipis'
        ));
    }
}