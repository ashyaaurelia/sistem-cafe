@extends('layouts.app')

@section('content')

<h1>Daftar Bahan</h1>
<h2>Daftar Bahan Menipis</h2>

@if($bahansMenipis->count() > 0)
    <table border="1" cellpadding="10">
        <tr>
            <th>Nama Bahan</th>
            <th>Stok Saat Ini</th>
            <th>Stok Minimum</th>
            <th>Satuan</th>
        </tr>

        @foreach($bahansMenipis as $bahan)
            <tr>
                <td>{{ $bahan->nama }}</td>
                <td>{{ $bahan->stok }}</td>
                <td>{{ $bahan->stok_minimum }}</td>
                <td>{{ $bahan->satuan }}</td>
            </tr>
        @endforeach
    </table>
@else
    <p>Tidak ada bahan yang menipis</p>
@endif

<br>

<a href="/manajer/bahan/tambah">
    <button>+ Tambah Bahan</button>
</a>

<form action="/manajer/bahan/sinkronisasi" method="POST" style="display: inline;">
    @csrf
    <button type="submit">Update Harga Bahan</button>
</form>

<form action="/manajer/bahan/import" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Import Data Bahan (CSV):</label>
    <input type="file" name="file" accept=".csv" required>

    <button type="submit">Import CSV</button>
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