@extends('layouts.app')

@section('content')

<h1>Resep Menu</h1>

@foreach ($menus as $menu)

<h3>{{ $menu->nama }}</h3>

<p>
    <strong>HPP: Rp {{ number_format($menu->hpp, 0, ',', '.') }}</strong>
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