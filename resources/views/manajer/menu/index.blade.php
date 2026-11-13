@extends('layouts.app')

@section('content')

<h1>Daftar Menu</h1>

<a href="/manajer/menu/tambah">
    <button>+ Tambah Menu</button>
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>No</th>
        <th>Nama Menu</th>
        <th>Harga</th>
        <th>Kategori</th>
        <th>Aksi</th>
    </tr>

    @foreach($menus as $menu)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $menu->nama }}</td>
        <td>{{ number_format($menu->harga) }}</td>
        <td>{{ $menu->kategori }}</td>

        <td>
            <a href="/manajer/menu/{{ $menu->id }}/edit">
                <button>Edit</button>
            </a>

            <form action="/manajer/menu/{{ $menu->id }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')

                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection