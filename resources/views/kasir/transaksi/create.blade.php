@extends('layouts.kasir')
@section('content')

<style>
    .halaman-transaksi {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 20px;
        align-items: start;
    }

    .daftar-menu, .panel-pesanan {
        background: white;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .judul-panel {
        margin-top: 0;
        margin-bottom: 20px;
    }

    .menu-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 12px;
    }

    .menu-card h3 {
        margin: 0 0 8px;
    }

    .harga-menu {
        color: #8b5e3c;
        font-weight: bold;
    }

    .btn-tambah {
        background: #6f4e37;
        color: white;
        border: none;
        padding: 9px 15px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .pesanan-kosong {
        color: #888;
        text-align: center;
        padding: 35px 10px;
    }

    @media (max-width: 900px) {
        .halaman-transaksi {
            grid-template-columns: 1fr;
        }
    }
</style>

@if (session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif 

@if (session('error'))
    <p style="solor:red;">
        {{ session('error') }}
    </p>
@endif

@if ($errors->any())
    <p style="color: red;">
        {{ $errors->first() }}
    </p>
@endif

<h1>Buat Transaksi</h1>
<p>Pilih menu untuk pesanan pelanggan</p>

<div class="halaman-transaksi">

    <div class="daftar-menu">

        <h2 class="judul-panel">Daftar Menu</h2>

        @foreach ($menus as $menu)

            <div class="menu-card">

                <h3>{{ $menu->nama }}</h3>

                <p>{{ $menu->kategori }}</p>

                <p class="harga-menu">
                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                </p>

                @if ($menu->bisa_dipesan)
                    <button type="button" class="btn-tambah"
                        data-id="{{ $menu->id }}"
                        data-nama="{{ $menu->nama }}"
                        data-harga="{{ $menu->harga }}">
                        + Tambah
                    </button>
                @else
                    <button type="button" disabled
                        style="background: #ccc; color: #666; border: none; padding: 9px 15px; border-radius: 5px; cursor: not-allowed; margin-top: 10px;">
                        Habis
                    </button>
                @endif
            </div>

        @endforeach

        @if ($menus->count() == 0)
            <p>Belum ada menu aktif.</p>
        @endif

    </div>

    
    <div class="panel-pesanan">
        <h2 class="judul-panel">Pesanan</h2>

        <form id="form-transaksi" method="POST" action="/kasir/transaksi">
            @csrf

            <input type="hidden" name="pesanan" id="pesanan-input">

            <div id="daftar-pesanan">
                <p class="pesanan-kosong">
                    Belum ada menu yang dipilih.
                </p>
            </div>

            <hr>

            <h3>
                Total: Rp <span id="total-pesanan">0</span>
            </h3>

            <label for="metode_pembayaran">Metode Pembayaran</label>

            <select name="metode_pembayaran" id="metode_pembayaran" required>
                <option value="">Pilih pembayaran</option>
                <option value="Tunai">Tunai</option>
                <option value="QRIS">QRIS</option>
            </select>

            <br><br>

            <button type="submit" class="btn-tambah">
                Simpan Transaksi
            </button>
        </form>
    </div>


</div>


<script>
    let pesanan = [];

    const tombolTambah = document.querySelectorAll('.daftar-menu .btn-tambah');
    const daftarPesanan = document.getElementById('daftar-pesanan');
    const totalPesanan = document.getElementById('total-pesanan');

    tombolTambah.forEach(function(tombol) {
        tombol.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const harga = Number(this.dataset.harga);

            const menuAda = pesanan.find(item => item.id === id);

            if (menuAda) {
                menuAda.jumlah++;
            } else {
                pesanan.push({
                    id: id,
                    nama: nama,
                    harga: harga,
                    jumlah: 1
                });
            }

            tampilkanPesanan();
        });
    });

    
    function tampilkanPesanan() {
        daftarPesanan.innerHTML = '';

        let total = 0;

        pesanan.forEach(function(item, index) {
            const subtotal = item.harga * item.jumlah;
            total += subtotal;

            daftarPesanan.innerHTML += `
                <div style="margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                    <strong>${item.nama}</strong>

                    <p>
                        Rp ${item.harga.toLocaleString('id-ID')}
                    </p>

                    <button type="button" onclick="ubahJumlah(${index}, -1)">−</button>

                    <strong style="margin: 0 10px;">${item.jumlah}</strong>

                    <button type="button" onclick="ubahJumlah(${index}, 1)">+</button>

                    <button type="button" onclick="hapusPesanan(${index})">
                        Hapus
                    </button>

                    <p>Subtotal: Rp ${subtotal.toLocaleString('id-ID')}</p>
                </div>
            `;
        });

        if (pesanan.length === 0) {
            daftarPesanan.innerHTML =
                '<p class="pesanan-kosong">Belum ada menu yang dipilih.</p>';
        }

        totalPesanan.textContent = total.toLocaleString('id-ID');
    }

    function ubahJumlah(index, perubahan) {
        pesanan[index].jumlah += perubahan;

        if (pesanan[index].jumlah <= 0) {
            pesanan.splice(index, 1);
        }

        tampilkanPesanan();
    }

    function hapusPesanan(index) {
        pesanan.splice(index, 1);
        tampilkanPesanan();
    }

    document.getElementById('form-transaksi').addEventListener('submit', function(e) {
    if (pesanan.length === 0) {
        e.preventDefault();
        alert('Pilih menu terlebih dahulu!');
        return;
    }

    document.getElementById('pesanan-input').value = JSON.stringify(
        pesanan.map(function(item) {
            return {
                id: item.id,
                jumlah: item.jumlah
            };
        })
    );
});

</script>

@endsection