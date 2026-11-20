@extends('layouts.app')
@section('content')

<h1>Laporan Penjualan dan Margin</h1>
<h2>Penjualan Per Menu</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Menu</th>
        <th>Total Terjual</th>
        <th>Total Penjualan</th>
    </tr>

    @forelse ($penjualan as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_menu }}</td>
            <td>{{ $item->total_terjual }}</td>
            <td>Rp {{ number_format($item->total_penjualan, 0, ',', '.') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4">Belum ada data penjualan</td>
        </tr>
    @endforelse
</table>

<br>

<h2>Margin Per Menu</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Menu</th>
        <th>Harga Jual</th>
        <th>HPP</th>
        <th>Margin</th>
    </tr>

    @foreach ($menus as $menu)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $menu->nama }}</td>
            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($menu->hpp, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($menu->margin, 0, ',', '.') }}</td>
        </tr>
    @endforeach
</table>

<br>

<h2>Laporan Bahan Menipis</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Bahan</th>
        <th>Stok Saat Ini</th>
        <th>Stok Minimum</th>
        <th>Satuan</th>
    </tr>

    @forelse ($bahansMenipis as $bahan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $bahan->nama }}</td>
            <td>{{ $bahan->stok }}</td>
            <td>{{ $bahan->stok_minimum }}</td>
            <td>{{ $bahan->satuan }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">Tidak ada bahan menipis</td>
        </tr>
    @endforelse
</table>

@endsection