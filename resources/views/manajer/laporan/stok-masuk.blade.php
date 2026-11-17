@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Laporan Stok Masuk</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Bahan</th>
                <th>Jumlah Masuk</th>
                <th>Satuan</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($stokMasuks as $stok)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $stok->tanggal }}</td>
                    <td>{{ $stok->bahan->nama }}</td>
                    <td>{{ $stok->jumlah }}</td>
                    <td>{{ $stok->bahan->satuan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada data stok masuk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection