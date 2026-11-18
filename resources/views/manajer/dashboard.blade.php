
@extends('layouts.app')

@section('content')

<h1>Dashboard Manajer</h1>

<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">

    <div style="border: 1px solid #ccc; padding: 20px; width: 200px; text-align: center; border-radius: 8px;">
        <h3>Total Menu</h3>
        <h1>{{ $totalMenu }}</h1>
    </div>

    <div style="border: 1px solid #ccc; padding: 20px; width: 200px; text-align: center; border-radius: 8px;">
        <h3>Total Bahan</h3>
        <h1>{{ $totalBahan }}</h1>
    </div>

    <div style="border: 1px solid #ccc; padding: 20px; width: 200px; text-align: center; border-radius: 8px;">
        <h3>Stok Masuk Hari Ini</h3>
        <h1>{{ $stokMasukHariIni }}</h1>
    </div>

</div>

<h2 style="margin-top: 40px;">Riwayat Stok Masuk Terbaru</h2>

<table border="1" cellpadding="10" cellspacing="0" width="100%">

    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Bahan</th>
            <th>Jumlah Masuk</th>
            <th>Satuan</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($stokMasuks as $stok)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $stok->tanggal }}</td>
                <td>{{ $stok->bahan->nama }}</td>
                <td>{{ $stok->jumlah }}</td>
                <td>{{ $stok->bahan->satuan }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center;">
                    Belum ada riwayat stok masuk.
                </td>
            </tr>
        @endforelse
    </tbody>

</table>

@endsection
