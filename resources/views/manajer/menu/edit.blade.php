@extends('layouts.app')

@section('content')

<h1>Edit Menu</h1>

<form action="/manajer/menu/{{ $menu->id }}" method="POST">

    @csrf
    @method('PUT')

    <label>Nama Menu</label>
    <br>
    <input type="text" name="nama" value="{{ $menu->nama }}" required>

    <br><br>

    <label>Harga</label>
    <br>
    <input type="number" name="harga" value="{{ $menu->harga }}" required>

    <br><br>

    <label>Kategori</label>
    <br>

    <select name="kategori">
        <option value="Minuman"
            {{ $menu->kategori == 'Minuman' ? 'selected' : '' }}>
            Minuman
        </option>

        <option value="Makanan"
            {{ $menu->kategori == 'Makanan' ? 'selected' : '' }}>
            Makanan
        </option>
    </select>

    <br><br>

    <button type="submit">Simpan Perubahan</button>

</form>

<br>
<a href="/manajer/menu">Kembali<a>

@endsection