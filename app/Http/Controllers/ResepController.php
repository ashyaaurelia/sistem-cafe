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
    public function edit(Resep $resep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resep $resep)
    {
        //
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
}
