<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // menampilkan semua menu
    public function index()
    {
        $menus = Menu::all();

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

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect('/manajer/menu');
    }
}