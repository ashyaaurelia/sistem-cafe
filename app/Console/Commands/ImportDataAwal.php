<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Bahan;
use App\Models\Menu;
use App\Models\Resep;
use Illuminate\Support\Facades\DB;

#[Signature('app:import-data-awal')]
#[Description('Command description')]
class ImportDataAwal extends Command
{
    /**
     * Execute the console command.
     */
public function handle()
{
    $lokasi = database_path('data/varian-c-kafe/bahan.csv');

    if (!file_exists($lokasi)) {
        $this->error('File bahan.csv tidak ditemukan!');
        return Command::FAILURE;
    }

    $file = fopen($lokasi, 'r');

    if (!$file) {
        $this->error('File bahan.csv gagal dibuka!');
        return Command::FAILURE;
    }

    fgetcsv($file);

    $berhasil = 0;
    $dilewati = 0;
    $kodeTerpakai = [];

    while (($data = fgetcsv($file)) !== false) {

        if (count($data) < 5) {
            $dilewati++;
            continue;
        }

        $kode = trim($data[0]);
        $nama = trim($data[1]);
        $stokRaw = trim($data[2]);
        $stok = (float) $stokRaw;
        $satuan = strtolower(trim($data[3]));

        if (
            $kode == '' ||
            $nama == '' ||
            !is_numeric($stokRaw) ||
            $stok < 0 ||
            in_array($kode, $kodeTerpakai)
        ) {
            $dilewati++;
            continue;
        }

        $kodeTerpakai[] = $kode;

        // Konversi satuan
        if ($satuan == 'kg') {
            $stok *= 1000;
            $satuan = 'g';
        } elseif ($satuan == 'liter') {
            $stok *= 1000;
            $satuan = 'ml';
        }

        if (!in_array($satuan, ['g', 'ml', 'pcs'])) {
            $dilewati++;
            continue;
        }

        $bahan = Bahan::firstOrNew([
            'kode' => $kode
        ]);

        $bahan->nama = $nama;
        $bahan->stok = $stok;
        $bahan->satuan = $satuan;

        if (!$bahan->exists) {
            $bahan->stok_minimum = 0;
        }

        $bahan->save();

        $berhasil++;
    }

    fclose($file);

    $this->info("Import bahan selesai!");
    $this->info("Berhasil: $berhasil");
    $this->info("Dilewati: $dilewati");

    $this->importMenu();
    $this->importResep();
    $this->importStokDemo();

    return Command::SUCCESS;
}

    private function importMenu()
    {
    $lokasi = database_path('data/varian-c-kafe/menu.csv');

    if (!file_exists($lokasi)) {
        $this->error('File menu.csv tidak ditemukan!');
        return;
    }

    $file = fopen($lokasi, 'r');

    if (!$file){
        $this->error('File menu.csv gagal dibuka');
        return;
    }

    fgetcsv($file);

    $berhasil = 0;
    $dilewati = 0;
    $kodeTerpakai = [];

    while (($data = fgetcsv($file)) !== false) {

        if (count($data) < 4) {
            $dilewati++;
            continue;
        }

        $kode = trim($data[0]);
        $nama = trim($data[1]);
        $kategori = trim($data[2]);
        $harga = trim($data[3]);

        if (
            $kode == '' ||
            $nama == '' ||
            $kategori == '' ||
            !is_numeric($harga) ||
            $harga < 0 ||
            in_array($kode, $kodeTerpakai)
        ) {
            $dilewati++;
            continue;
        }

        $kodeTerpakai[] = $kode;

        Menu::updateOrCreate(
            ['kode' => $kode],
            [
                'nama' => $nama,
                'kategori' => $kategori,
                'harga' => $harga,
            ]
        );

        $berhasil++;
    }

    fclose($file);

    $this->info("Import menu selesai!");
    $this->info("Berhasil: $berhasil");
    $this->info("Dilewati: $dilewati");
    }

    public function importResep()
    {
        $lokasi = database_path('data/varian-c-kafe/resep.csv');

        if(!file_exists($lokasi)) {
            $this->error('File resep.csv tidak ditemukan');
            return;
        }

        $file = fopen($lokasi, 'r');
        if(!$file){
            $this->error('File resep.csv gagal dibuka');
            return;
        }
        fgetcsv($file);

        $berhasil = 0;
        $dilewati = 0;

        // pencocokan nama bahan yang salah ketik
        $pencocokan = [
            'Biji kopi arabica' => 'Biji kopi arabika',
        ];

        while (($data = fgetcsv($file)) !== false){
            if(count($data) < 4){
                $dilewati++;
                continue;
            }

            $kodeMenu = trim($data[0]);
            $namaBahan = trim($data[1]);
            $takaran = trim($data[2]);
            $satuan = strtolower(trim($data[3]));

            if(
                $kodeMenu == '' ||
                $namaBahan == '' ||
                !is_numeric($takaran) ||
                $takaran <= 0
            ) {
                $dilewati++;
                continue;
            }

            // perbaiki nama bahan jika salah ketik
            $namaBahan = $pencocokan[$namaBahan] ?? $namaBahan;

            // cari menu berdasarkan kode
            $menu = Menu::where('kode', $kodeMenu)->first();

            // cari bahan berdasarkan nama
            $bahan = Bahan::where('nama', $namaBahan)->first();

            // lewati jika menu atau bahan tidak ditemukan
            if(!$menu || !$bahan) {
                $dilewati++;
                continue;
            }

            if($satuan != $bahan->satuan){
                $dilewati++;
                continue;
            }
            Resep::updateOrCreate(
                [
                    'menu_id' => $menu->id,
                    'bahan_id' => $bahan->id,
                ],
                [
                    'jumlah' => $takaran,
                ]
            );

            $berhasil++;
        }
        fclose($file);

        $this->info("Import resep selesai");
        $this->info("Berhasil: $berhasil");
        $this->info("Dilewati: $dilewati");
    }

    private function importStokDemo()
    {
        $lokasi = database_path('data/varian-c-kafe/seed_stok_demo.csv');

        if(!file_exists($lokasi)){
            $this->error('File seed_stok_demo.csv tidak ditemukan');
            return;
        }
        $file = fopen($lokasi, 'r');

        if(!$file){
            $this->error('File seed_stok_demo.csv gagal dibuka');
            return;
        }

        fgetcsv($file);

        $berhasil = 0;
        $dilewati = 0;

        while (($data = fgetcsv($file)) !== false){
            if (count($data) < 3){
                $dilewati++;
                continue;
            }

            $nama = trim($data[0]);
            $jumlahRaw = trim($data[1]);
            $satuan = strtolower(trim($data[2]));

            if ($nama == '' || !is_numeric($jumlahRaw) || $jumlahRaw < 0){
                $dilewati++;
                continue;
            }

            $bahan = Bahan::where('nama', $nama)->first();

            if (!$bahan){
                $dilewati++;
                continue;
            }

            // konversi satuan
            $jumlah = (float) $jumlahRaw;

            if ($satuan == 'liter'){
                $jumlah *= 1000;
                $satuan = 'ml';
            } elseif ($satuan == 'kg'){
                $jumlah *= 1000;
                $satuan = 'g';
            }

            if ($satuan != $bahan->satuan){
                $dilewati++;
                continue;
            }

            $bahan->stok = $jumlah;
            $bahan->save();

            $berhasil++;
        }

        fclose($file);

        $this->info("Import stok demo selesai");
        $this->info("Berhasil: $berhasil");
        $this->info("Dilewati: $dilewati");
    }
}
