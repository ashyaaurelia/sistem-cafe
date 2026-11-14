@extends('layouts.app')

@section('content')

<h1>Daftar Bahan</h1>

<a href="/manajer/bahan/tambah">
    <button>+ Tambah Bahan</button>
</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Bahan</th>
        <th>Stok</th>
        <th>Satuan</th>
        <th>Stok Minimum</th>
        <th>Aksi</th>
    </tr>

    @foreach($bahans as $bahan)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $bahan->nama }}</td>
        <td>{{ $bahan->stok }}</td>
        <td>{{ $bahan->satuan }}</td>
        <td>{{ $bahan->stok_minimum }}</td>

        <td>
            <a href="/manajer/bahan/{{ $bahan->id }}/edit">
                <button>Edit</button>
            </a>

            <form action="/manajer/bahan/{{ $bahan->id }}" method="POST">
                @csrf
                @method('DELETE')

                <button>Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@endsection