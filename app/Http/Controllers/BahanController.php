<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\Request;
use App\Services\UkkApiServices;

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
            'harga' => $request->harga,
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
            'harga' => $request->harga,
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

    public function sinkronisasi(UkkApiServices $api)
    {
        $hasil = $api->getHargaBahan();

        if (!$hasil || !isset($hasil['data'])){
            return redirect('/manajer/bahan')->with('error', 'Supplier API tidak tersedia. Sistem tetap menggunakan harga terakhir yang tersimpan.');
        }

        foreach ($hasil['data'] as $item){
            $bahan = Bahan::firstOrNew(
                ['kode' => $item['kode']]);
                
                $bahan->nama = $item['nama'];
                $bahan->satuan = $item['satuan_dasar'];
                $bahan->harga = $item['harga_per_satuan'];
                $bahan->harga_diperbarui_pada = $hasil['diperbarui'];

                if (!$bahan->exists){
                    $bahan->stok = 0;
                    $bahan->stok_minimum = 0;
                }
                $bahan->save();
        }
        return redirect('/manajer/bahan')->with('success', 'Harga bahan berhasil disinkronsasi');
    }
}