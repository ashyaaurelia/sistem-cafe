<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokMasuk;
use App\Models\Bahan;
Use Illuminate\Support\Facades\DB;

class StokMasukController extends Controller
{
    public function index()
    {
        $bahans = Bahan::all();
        return view('manajer.stok-masuk.index', compact('bahans'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'bahan_id' => 'required|exists:bahans,id',
            'jumlah' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request){
            StokMasuk::create([
                'tanggal' => $request->tanggal,
                'bahan_id' => $request->bahan_id,
                'jumlah' => $request->jumlah,
            ]);

            $bahan = Bahan::findOrFail($request->bahan_id);
            $bahan->stok += $request->jumlah;
            $bahan->save();
        });

        return redirect('/manajer/stok-masuk')->with('success', 'Stok masuk berhasil disimpan');
    }

    public function laporan()
    {
        $stokMasuks = StokMasuk::with('bahan')->orderBy('tanggal', 'desc')->get();
        return view('manajer.laporan.stok-masuk', compact('stokMasuks'));
    }
}
