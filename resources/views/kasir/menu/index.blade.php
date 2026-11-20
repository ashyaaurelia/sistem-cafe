@extends('layouts.kasir')
@section('content')

<style>
    .judul{
        margin-bottom: 20px;
    }

    .tabel-menu{
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .tabel-menu th,
    .tabel-menu td{
        padding: 14px;
        border: 1px solid #333;
        text-align: left;
    }

    .tabel-menu th{
        background: #eeeeee;
    }

    .tabel-menu tr:hover{
        background: #f9f9f9;
    }
</style>

<div class="judul">
    <h1>Daftar Menu</h1>
    <p>Daftar menu yang terseidua untuk pelanggan</p>
</div>

<table class="tabel-menu">
    <tr>
        <th>No</th>
        <th>Nama Menu</th>
        <th>Kategori</th>
        <th>Harga</th>
    </tr>

    @forelse ($menus as $menu)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $menu->nama }}</td>
            <td>{{ $menu->kategori }}</td>
            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
        </tr>
    @empty
    <tr>
        <td colspan="4" style="text-align: center;">Belum ada menu aktif</td>
    </tr>
    @endforelse
</table>

@endsection