<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use App\Models\Resep;
use App\Models\Bahan;


class TransaksiController extends Controller
{
    public function index(){
        $transaksis = Transaksi::orderBy('tanggal', 'desc')->get();
        return view('kasir.transaksi.index', compact('transaksis'));
    }

    public function create(){
        $menus = \App\Models\Menu::where('status', 'aktif')->orderBy('nama')->get();
        return view('kasir.transaksi.create', compact('menus'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'pesanan' => 'required|string',
            'metode_pembayaran' => 'required|in:Tunai,QRIS',
        ]);

        $pesanan = json_decode($request->pesanan, true);

        if (!is_array($pesanan) || count($pesanan) == 0) {
            return back()->with('error', 'Pesanan tidak valid!');
        }

        $detailPesanan = [];
        $subtotal = 0;

        foreach ($pesanan as $item) {

            if (!is_array($item) || !isset($item['id']) || !isset($item['jumlah'])) {
                return back()->with('error', 'Data pesanan tidak lengkap!');
            }

            $jumlah = filter_var($item['jumlah'], FILTER_VALIDATE_INT);

            if ($jumlah === false || $jumlah < 1) {
                return back()->with('error', 'Jumlah pesanan tidak valid!');
            }

            $menu = Menu::where('id', $item['id'])
                ->where('status', 'aktif')
                ->first();

            if (!$menu) {
                return back()->with('error', 'Menu tidak ditemukan!');
            }

            $harga = $menu->harga;
            $totalItem = $harga * $jumlah;

            $subtotal += $totalItem;

            $detailPesanan[] = [
                'menu_id' => $menu->id,
                'nama_menu' => $menu->nama,
                'jumlah' => $jumlah,
                'harga' => $harga,
                'subtotal' => $totalItem,
            ];
        }

        try{
        $transaksi = DB::transaction(function () use ($request, $detailPesanan, $subtotal) {

            $transaksi = Transaksi::create([
                'nomor_transaksi' => 'TRX-' . now()->format('YmdHis') . '-' . random_int(100, 999),
                'tanggal' => now(),
                'subtotal' => $subtotal,
                'biaya_layanan' => 0,
                'pajak' => 0,
                'total' => $subtotal,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'baru',
            ]);

            foreach ($detailPesanan as $detail) {

        $transaksi->detailTransaksis()->create($detail);

        $reseps = Resep::where('menu_id', $detail['menu_id'])->get();

        foreach ($reseps as $resep) {

            $bahan = Bahan::where('id', $resep->bahan_id)
                ->lockForUpdate()
                ->first();

            $kebutuhan = $resep->jumlah * $detail['jumlah'];

            if (!$bahan || $bahan->stok < $kebutuhan) {
                throw new \Exception(
                    'Stok bahan tidak mencukupi untuk menu ' . $detail['nama_menu']
                );
            }

            $bahan->decrement('stok', $kebutuhan);
        }
    }

            return $transaksi;
        });

            return redirect('/kasir/transaksi/' . $transaksi->id);

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }

    } 

    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksis')->findOrFail($id);
        return view('kasir.transaksi.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, $id){
        $request->validate([
            'status' => 'required|in:baru,diproses,selesai',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status pesanan berhasil diubah');
    }

    public function batal($id)
{
    $transaksi = Transaksi::with('detailTransaksis')->findOrFail($id);

    if ($transaksi->status != 'baru') {
        return back()->with('error', 'Pesanan hanya bisa dibatalkan saat status Baru!');
    }

    DB::transaction(function () use ($transaksi) {

        foreach ($transaksi->detailTransaksis as $detail) {

            $reseps = Resep::where('menu_id', $detail->menu_id)->get();

            foreach ($reseps as $resep) {

                $kebutuhan = $resep->jumlah * $detail->jumlah;

                $bahan = Bahan::lockForUpdate()->find($resep->bahan_id);

                if ($bahan) {
                    $bahan->increment('stok', $kebutuhan);
                }
            }
        }

        $transaksi->update([
            'status' => 'dibatalkan',
        ]);
    });

    return back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan!');
}
}