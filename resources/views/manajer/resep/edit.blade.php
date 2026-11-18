@extends('layouts.app')

@section('content')

<h1>Edit Resep</h1>

<form action="/manajer/resep/{{ $resep->id }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Bahan</label>

        <select name="bahan_id" class="form-control" required>
            @foreach ($bahans as $bahan)
                <option value="{{ $bahan->id }}"
                    {{ $resep->bahan_id == $bahan->id ? 'selected' : '' }}>
                    {{ $bahan->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Jumlah</label>

        <input type="number"
            name="jumlah"
            class="form-control"
            step="0.01"
            min="0.01"
            value="{{ $resep->jumlah }}"
            required>
    </div>

    <button type="submit">Simpan Perubahan</button>

</form>

@endsection