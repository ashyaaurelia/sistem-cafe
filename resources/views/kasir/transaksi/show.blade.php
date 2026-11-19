
@extends('layouts.kasir')
@section('content')

<style>
    .struk {
        max-width: 600px;
        margin: auto;
        background: white;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 10px;
    }

    .struk h2, .struk p {
        text-align: center;
    }

    .struk table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .struk th, .struk td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    .kanan {
        text-align: right !important;
    }

    .tombol-struk {
        margin-top: 20px;
        padding: 10px 18px;
        background: #6f4e37;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    @media print {
        .header, .sidebar, .tombol-struk {
            display: none !important;
        }

        .content {
            margin: 0 !important;
            padding: 0 !important;
        }

        .struk {
            border: none;
            max-width: 100%;
        }
    }
</style>

<div class="struk">

    <h2>KEDAI KOPI SENJA</h2>
    <p>Bukti Pembayaran</p>

    <hr>

    <p>
        Nomor: {{ $transaksi->nomor_transaksi }}<br>
        Tanggal: {{ $transaksi->tanggal }}<br>
        Metode: {{ $transaksi->metode_pembayaran }}
    </p>

        <div class="status-pesanan">
        <h3>Status Pesanan: {{ ucfirst($transaksi->status) }}</h3>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if($transaksi->status == 'baru')
            <form action="/kasir/transaksi/{{ $transaksi->id }}/status" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="status" value="diproses">

                <button type="submit" class="tombol-struk">
                    Mulai Diproses
                </button>
            </form>

            <form action="/kasir/transaksi/{{ $transaksi->id }}/batal" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="tombol-struk" style="background: #c0392b;">
                        Batalkan Pesanan
                    </button>

        @elseif($transaksi->status == 'diproses')
            <form action="/kasir/transaksi/{{ $transaksi->id }}/status" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="status" value="selesai">

                <button type="submit" class="tombol-struk">
                    Selesaikan Pesanan
                </button>
            </form>
        @else
            <p style="color: green;">Pesanan sudah selesai.</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Jumlah</th>
                <th class="kanan">Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($transaksi->detailTransaksis as $detail)
                <tr>
                    <td>{{ $detail->nama_menu }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td class="kanan">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="kanan">
        Total: Rp {{ number_format($transaksi->total, 0, ',', '.') }}
    </h3>

    <p>Terima kasih telah berbelanja!</p>

    <button class="tombol-struk" onclick="window.print()">
        Cetak Struk
    </button>

    <button class="tombol-struk" onclick="window.location.href='/kasir/transaksi/create'">
        Kembali
    </button>

</div>

@endsection