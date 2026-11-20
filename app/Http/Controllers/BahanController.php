<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\Request;
use App\Services\UkkApiServices;
use App\Services\MenuAvailabilityService;

class BahanController extends Controller
{
    // menampilkan semua bahan
    public function index()
    {
        $bahans = Bahan::all();
        $bahansMenipis = Bahan::whereRaw(
            'CAST(stok AS DECIMAL(12,2)) <= CAST(stok_minimum AS DECIMAL(12,2))')->get();
            return view('manajer.bahan.index', compact('bahans', 'bahansMenipis'));
    }

    // menampilkan form tambah bahan
    public function create()
    {
        return view('manajer.bahan.create');
    }

    // menyimpan bahan
    public function store(Request $request, MenuAvailabilityService $menuAvailability)
    {
        $request->validate([
            'nama' => 'required|string|unique:bahans,nama',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|in:g,ml,pcs',
        ]);

        Bahan::create([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'stok_minimum' => $request->stok_minimum,
            'harga' => $request->harga,
        ]);
        $menuAvailability_>sync();

        return redirect('/manajer/bahan');
    }

    // menampilkan form edit bahan
    public function edit($id)
    {
        $bahan = Bahan::findOrFail($id);
        return view('manajer.bahan.edit', compact('bahan'));
    }

    // mengupdate bahan
    public function update(Request $request, $id, MenuAvailabilityService $menuAvailability)
    {
        $bahan = Bahan::findOrFail($id);

        $bahan->update([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'stok_minimum' => $request->stok_minimum,
            'harga' => $request->harga,
        ]);
        $menuAvailability->sync();

        return redirect('/manajer/bahan');
    }

    // menghapus bahan
    public function destroy($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();
        return redirect('/manajer/bahan');
    }

    public function import(Request $request, MenuAvailabilityService $menuAvailability)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');
        $header = fgetcsv($file);

        $berhasil = 0;
        $dilewati = 0;

        while (($data = fgetcsv($file)) !== false){
            if (count($data) < 5){
                $dilewati++;
                continue;
            }

            $kode = trim($data[0]);
            $nama = trim($data[1]);
            $stokRaw = trim($data[2]);
            $satuan = strtolower(trim($data[3]));

            if (!$kode || !$nama || !is_numeric($stokRaw) || $stokRaw < 0){
                $dilewati++;
                continue;
            }
            $stok = (float) $stokRaw;

            if ($satuan == 'kg'){
                $stok = $stok * 1000;
                $satuan = 'g';
            } elseif ($satuan == 'liter'){
                $stok = $stok * 1000;
                $satuan = 'ml';
            }

            if (!in_array($satuan, ['g', 'ml', 'pcs'])){
                $dilewati++;
                continue;
            }

            $bahan = Bahan::where('kode', $kode)->first();

            if(!$bahan){
                $dilewati++;
                continue;
            }

            $bahan->stok = $stok;
            $bahan->satuan = $satuan;
            $bahan->save();

            $berhasil++;
        }
        $menuAvailability->sync();

        fclose($file);
        return redirect('/manajer/bahan')->with(
            'success', "Import selesai. Berhasil: $berhasil bahan. Dilewati: $dilewati data."
        );
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