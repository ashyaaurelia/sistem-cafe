<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Bahan;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        return view ('manajer.resep.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        $bahans = Bahan::all();

        return view('manajer.resep.create', compact('menu', 'bahans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required',
            'bahan_id' => 'required',
            'jumlah' => 'required|numeric|min:0.01',
        ]);

        Resep::create([
            'menu_id' => $request->menu_id,
            'bahan_id' => $request->bahan_id,
            'jumlah' => $request->jumlah,
        ]);
        return redirect('/manajer/resep');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resep $resep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $resep = Resep::findOrFail($id);
        $bahans= Bahan::all();

        return view('manajer.resep.edit', compact('resep', 'bahans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'bahan_id' => 'required|exists:bahans,id',
            'jumlah' => 'required|numeric|min:0.01',
        ]);

        $resep = Resep::findOrFail($id);
        $resep->update([
            'bahan_id' => $request->bahan_id,
            'jumlah' => $request->jumlah,
        ]);
        return redirect('/manajer/resep');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resep = Resep::findOrFail($id);
        $resep->delete();
        return redirect('/manajer/resep');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');
        $header = fgetcsv($file);

        $berhasil = 0;
        $dilewati = 0;

        while (($data = fgetcsv($file)) !== false){
            if (count($data) < 4){
                $dilewati++;
                continue;
            }

            $kodeMenu = trim($data[0]);
            $namaBahan = trim($data[1]);
            $takaran = trim($data[2]);
            $satuan = strtolower(trim($data[3]));

            $menu = Menu::where('kode', $kodeMenu)->first();

            if(!$menu || !is_numeric($takaran) || $takaran <= 0){
                $dilewati++;
                continue;
            }

            $namaCari = strtolower(trim(preg_replace('/\s+/', ' ', $namaBahan)));
            $daftarBahan = Bahan::where('satuan', $satuan)->get();

            $bahan = $daftarBahan->first(function ($item) use ($namaCari) {
                $namaDatabase = strtolower(trim(preg_replace('/\s+/', ' ', $item->nama)));

                return $namaDatabase == $namaCari;
            });

            if (!$bahan){
                $kandidat = [];

                foreach ($daftarBahan as $item){
                    $namaDatabase = strtolower(trim(preg_replace('/\s+/', ' ', $item->nama)));
                    $jarak = levenshtein($namaCari, $namaDatabase);
                    $batas = max(1, floor(strlen($namaCari) * 0.2));

                    if ($jarak <= $batas){
                        $kandidat[] = [
                            'bahan' => $item,
                            'jarak' => $jarak,
                        ];
                    }
                }
                usort($kandidat, fn($a, $b) => $a['jarak'] <=> $b['jarak']);

                if (count($kandidat) == 1 ||
                    (count($kandidat) > 1 && $kandidat[0]['jarak'] < $kandidat[1]['jarak'])){
                    $bahan = $kandidat[0]['bahan'];
                }
            }

            if(!$bahan){
                $dilewati++;
                continue;
            }
            $resep = Resep::where('menu_id', $menu->id)
                ->where('bahan_id', $bahan->id)
                ->first();

            if ($resep){
                $dilewati++;
                continue;
            }

            Resep::create([
                'menu_id' => $menu->id,
                'bahan_id' => $bahan->id,
                'jumlah' => $takaran,
            ]);

            $berhasil++;
        }
        fclose($file);

        return redirect('/manajer/resep')->with(
            'success', "Import selesai. Berhasil: $berhasil resep. Dilewati: $dilewati data."
        );
    }
}
