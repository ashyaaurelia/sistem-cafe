@extends('layouts.app')

@section('content')

<h1>Tambah Menu</h1>

<form action="/manajer/menu" method="POST">

    @csrf

    <label>Nama Menu</label>
    <br>
    <input type="text" name="nama" required>

    <br><br>

    <label>Harga</label>
    <br>
    <input type="number" name="harga" required>

    <br><br>

    <label>Kategori</label>
    <br>
    <select name="kategori">
        <option value="Minuman">Minuman</option>
        <option value="Makanan">Makanan</option>
    </select>

    <br><br>

    <button type="submit">Simpan</button>

</form>

<br>

<a href="/manajer/menu">Kembali</a>

@endsection