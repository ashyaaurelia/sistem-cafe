@extends('layouts.app')

@section('content')

<h1>Daftar Bahan</h1>

<a href="/manajer/bahan/tambah">
    <button>+ Tambah Bahan</button>
</a>

<form action="/manajer/bahan/sinkronisasi" method="POST" style="display: inline;">
    @csrf
    <button type="submit">Sinkronisasi Harga Supplier</button>
</form>

<br><br>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Nama Bahan</th>
        <th>Stok</th>
        <th>Satuan</th>
        <th>Stok Minimum</th>
        <th>Harga</th>
        <th>Diperbarui Pada</th>
        <th>Aksi</th>
    </tr>

    @foreach($bahans as $bahan)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $bahan->kode ?? '-' }}</td>
        <td>{{ $bahan->nama }}</td>
        <td>{{ $bahan->stok }}</td>
        <td>{{ $bahan->satuan }}</td>
        <td>{{ $bahan->stok_minimum }}</td>
        <td>{{ number_format($bahan->harga ?? 0, 0, ',', '.') }}</td>
        <td>{{ $bahan->harga_diperbarui_pada ? \Carbon\Carbon::parse($bahan->harga_diperbarui_pada)->format('d-m-Y') : '-' }}</td>

        <td>
            <a href="/manajer/bahan/{{ $bahan->id }}/edit">
                <button>Edit</button>
            </a>

            <form action="/manajer/bahan/{{ $bahan->id }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@endsection