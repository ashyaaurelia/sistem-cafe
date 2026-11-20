@extends('layouts.app')
@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
    <p style="color: red;">{{ $error }}</p>
    @endforeach
@endif

@if (session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

<h1>Resep Menu</h1>

<h2>Import Resep dari CSV</h2>
<form action ="/manajer/resep/import" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" accept=".csv" required>
    <button type="submit">Import Resep</button>
</form>

<br>

@foreach ($menus as $menu)

<h3>{{ $menu->nama }}</h3>

<p>
    Harga Jual: Rp {{ number_format($menu->harga, 0, ',', '.') }}
</p>

<p>
    HPP: Rp {{ number_format($menu->hpp, 0, ',', '.') }}
</p>

<p>
    <strong>Margin: Rp {{ number_format($menu->margin, 0, ',', '.') }}</strong>
</p>

<a href="/manajer/resep/{{ $menu->id }}/create">
    <button>Tambah Resep</button>
</a>

@if ($menu->reseps->count() > 0)

<table border="1" cellpadding="8">
    <tr>
        <th>Bahan</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Aksi</th>
    </tr>

    @foreach ($menu->reseps as $resep)
    <tr>
        <td>{{ $resep->bahan->nama }}</td>
        <td>{{ $resep->jumlah }}</td>
        <td>{{ $resep->bahan->satuan }}</td>
        <td>
            <a href="/manajer/resep/{{ $resep->id }}/edit">
                <button type="button">Edit</button>
            </a>
        
            <form action="/manajer/resep/{{ $resep->id }}" method="POST">
                @csrf
                @method('DELETE')
                
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@else
<p>Belum ada resep.</p>
@endif

<hr>

@endforeach
@endsection