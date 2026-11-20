<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\Bahan;
use App\Models\Resep;

class MenuAvailabilityService
{
    /**
     * Create a new class instance.
     */
    public function sync()
    {
        $menus = Menu::with('reseps')->get();
        
        foreach ($menus as $menu){
            $reseps = $menu->reseps;
            $bisaDipesan = $reseps->isNotEmpty();
            $kelompokResep = $reseps->groupBy('bahan_id');

            foreach ($kelompokResep as $bahanId => $daftarResep){
                $bahan = Bahan::find($bahanId);
                $kebutuhan = $daftarResep->sum('jumlah');

                if(!$bahan || $bahan->stok < $kebutuhan){
                    $bisaDipesan = false;
                    break;
                }
            }

            if($bisaDipesan && $menu->status == 'habis'){
                $menu->status = 'aktif';
                $menu->save();
            }

            if(!$bisaDipesan && $menu->status == 'aktif'){
                $menu->status = 'habis';
                $menu->save();
            }
        }
    }
}