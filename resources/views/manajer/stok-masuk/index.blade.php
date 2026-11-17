@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Stok Masuk</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="/manajer/stok-masuk" method="POST">
        @csrf

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nama Bahan</label>
            <select name="bahan_id" class="form-control" required>
                <option value="">Pilih Bahan</option>

                @foreach ($bahans as $bahan)
                    <option value="{{ $bahan->id }}">
                        {{ $bahan->nama }} ({{ $bahan->satuan }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah Masuk (sesuai satuan bahan)</label>
            <input type="number" name="jumlah" class="form-control"
                step="0.01" min="0.01" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Stok Masuk
        </button>
    </form>
</div>

@endsection