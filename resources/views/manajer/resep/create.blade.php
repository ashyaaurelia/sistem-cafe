@extends('layouts.app')

@section('content')

<h1>Tambah Resep</h1>

<h3>Menu: {{ $menu->nama }}</h3>

<form action="/manajer/resep" method="POST">
    @csrf

    <input type="hidden" name="menu_id" value="{{ $menu->id }}">

    <div>
        <label>Bahan</label><br>

        <select name="bahan_id">
            <option value="">-- Pilih Bahan --</option>

            @foreach ($bahans as $bahan)
                <option value="{{ $bahan->id }}">
                    {{ $bahan->nama }} ({{ $bahan->satuan}})
                </option>
            @endforeach
        </select>
    </div>

    <br>
    
    <div>
        <label>Jumlah</label><br>

        <input
        type="number"
        name="jumlah"
        step="0.01"
        min="0.01">
    </div>

    <br>

    <button type="submit">Simpan Resep</button>

</form>
@endsection