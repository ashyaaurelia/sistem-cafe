<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // menampilkan semua menu
    public function index()
    {
        $menus = Menu::with('reseps.bahan')->get();

        foreach ($menus as $menu){
            $menu->hpp = 0;

            foreach ($menu->reseps as $resep){
                $menu->hpp += $resep->jumlah * $resep->bahan->harga;
            }
            $menu->margin = $menu->harga - $menu->hpp;
        }

        return view('manajer.menu.index', compact('menus'));
    }

    // menampilkan halaman tambah menu
    public function create()
    {
        return view ('manajer.menu.create');
    }

    //menyimpan menu
    public function store(Request $request)
    {
        Menu::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'status' => $request->status,
        ]);

        return redirect('/manajer/menu');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        return view('manajer.menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findorFail($id);

        $menu->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
        ]);

        return redirect('/manajer/menu');
    }

    public function ubahStatus($id)
    {
        $menu = Menu::findOrFail($id);

        if($menu->status != 'nonaktif'){
            $menu->status = 'nonaktif';
        } else {
            $reseps = $menu->reseps()->with('bahan')->get();

            if($reseps->isEmpty()){
                return redirect('/manajer/menu')->with('error', 'Menu belum memiliki resep');
            }

            $kelompokResep = $reseps->groupBy('bahan_id');

            foreach($kelompokResep as $bahanId => $daftarResep){
                $bahan = $daftarResep->first()->bahan;
                $kebutuhan = $daftarResep->sum('jumlah');

                if(!$bahan || $bahan->stok < $kebutuhan){
                    return redirect('/manajer/menu')->with('error', 'Stok bahan tidak mencukupi');
                }
            }
            $menu->status = 'aktif';
        }
        $menu->save();

        return redirect('/manajer/menu');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect('/manajer/menu');
    }
}