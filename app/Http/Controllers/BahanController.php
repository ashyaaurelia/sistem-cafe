<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    // menampilkan semua bahan
    public function index()
    {
        $bahans = Bahan::all();
        return view ('manajer.bahan.index', compact('bahans'));
    }

    // menampilkan form tambah bahan
    public function create()
    {
        return view('manajer.bahan.create');
    }

    // menyimpan bahan
    public function store(Request $request)
    {
        Bahan::create([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'stok_minimum' => $request->stok_minimum,
        ]);
        return redirect('/manajer/bahan');
    }

    // menampilkan form edit bahan
    public function edit($id)
    {
        $bahan = Bahan::findOrFail($id);
        return view('manajer.bahan.edit', compact('bahan'));
    }

    // mengupdate bahan
    public function update(Request $request, $id)
    {
        $bahan = Bahan::findOrFail($id);

        $bahan->update([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'stok_minimum' => $request->stok_minimum,
        ]);

        return redirect('/manajer/bahan');
    }

    // menghapus bahan
    public function destroy($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();
        return redirect('/manajer/bahan');
    }
}