@extends('layouts.kasir')
@section('content')

<h1>Riwayat Transaksi</h1>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Transaksi</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($transaksis as $transaksi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaksi->nomor_transaksi }}</td>
                <td>{{ $transaksi->tanggal }}</td>
                <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                <td>{{ ucfirst($transaksi->status) }}</td>
                <td>
                    <a href="/kasir/transaksi/{{ $transaksi->id }}">Lihat Struk</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" align="center">Belum ada transaksi</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection