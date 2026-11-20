@extends('layouts.app')

@section('content')

<h1>Tambah Bahan</h1>

<form action="/manajer/bahan" method="POST">
    @csrf

    <label>Nama Bahan</label>
    <br>
    <input type="text" name="nama" required>

    <br><br>

    <label>Stok</label>
    <br>
    <input type="number" name="stok" required>

    <br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" min="0">

    <br><br>

    <label>Satuan</label>
    <br>
    <select name="satuan">
        <option value="g">Gram (g)</option>
        <option value="ml">Mililiter (ml)</option>
        <option value="pcs">Pieces (pcs)</option>
    </select>

    <br><br>

    <label>Stok Minimum</label>
    <br>
    <input type="number" name="stok_minimum" required>

    <br><br>

    <button type="submit">Simpan</button>

</form>

<br>

<a href="/manajer/bahan">Kembali</a>

@endsection