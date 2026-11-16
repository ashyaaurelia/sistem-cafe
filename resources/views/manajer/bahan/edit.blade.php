@extends('layouts.app')

@section('content')

<h1>Edit Bahan</h1>

<form action="/manajer/bahan/{{ $bahan->id }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama Bahan</label>
    <br>
    <input type="text" name="nama" value="{{ $bahan->nama }}" required>

    <br><br>

    <label>Stok</label>
    <br>
    <input type="number" name="stok" value="{{ $bahan->stok }}" required>

    <br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" min="0" value="{{ $bahan->harga }}">

    <br><br>

    <label>Satuan</label>
    <br>
    <select name="satuan">
        <option value="gram" {{ $bahan->satuan == 'gram' ? 'selected' : '' }}>Gram</option>
        <option value="ml" {{ $bahan->satuan == 'ml' ? 'selected' : '' }}>ML</option>
        <option value="pcs" {{ $bahan->satuan == 'pcs' ? 'selected' : '' }}>PCS</option>
    </select>

    <br><br>

    <label>Stok Minimum</label>
    <br>
    <input type="number" name="stok_minimum" value="{{ $bahan->stok_minimum }}" required>

    <br><br>

    <button type="submit">Simpan Perubahan</button>

</form>

<br>

<a href="/manajer/bahan">Kembali</a>

@endsection