# Kedai Kopi Senja

**Kedai Kopi Senja** merupakan Sistem Informasi Manajemen Kedai Kopi berbasis web yang dibuat untuk membantu proses pengelolaan operasional kedai kopi.

Sistem ini dikembangkan menggunakan framework Laravel dan database MySQL. Sistem memiliki fitur pengelolaan menu, bahan baku, stok, resep, transaksi, serta laporan.

## Fitur Sistem

### 1. Manajer
- Mengelola data menu.
- Mengelola data bahan baku.
- Mengelola resep menu.
- Mengelola stok masuk.
- Melihat laporan sistem.
- Mengimpor data resep melalui file CSV.

### 2. Kasir
- Melihat daftar menu aktif.
- Melakukan transaksi penjualan.
- Mengelola status pesanan.
- Melihat riwayat transaksi.
- Mereset password pelanggan.

### 3. API Pelanggan (Backend)
- Registrasi akun pelanggan.
- Login menggunakan nomor HP dan password.
- Logout pelanggan.
- Mengganti password pelanggan.
- Reset password pelanggan oleh kasir.
- Menggunakan Laravel Sanctum untuk autentikasi API.

**Catatan:** Aplikasi Android pelanggan menggunakan Flutter masih dalam tahap pengembangan.

## Teknologi yang Digunakan

- **PHP 8.3** - Bahasa pemrograman backend.
- **Laravel 13** - Framework untuk membangun aplikasi web dan API.
- **MySQL** - Database untuk menyimpan data sistem.
- **HTML** - Membuat struktur halaman web.
- **CSS** - Mengatur tampilan halaman web.
- **JavaScript** - Menambahkan interaksi pada halaman web.
- **Laravel Sanctum** - Mengelola autentikasi API pelanggan.

## Persyaratan Sistem

Sebelum menjalankan project, pastikan perangkat sudah memiliki:

- PHP versi 8.3 atau lebih baru.
- Composer.
- Node.js dan NPM.
- MySQL.
- Web browser.

## Cara Instalasi

1. Clone repository:

   ```bash
   git clone https://github.com/ashyaaurelia/sistem-cafe.git
   ```

2. Masuk ke folder project:

   ```bash
   cd sistem-cafe
   ```

3. Install dependency Laravel:

   ```bash
   composer install
   ```

4. Salin file konfigurasi:

   ```bash
   cp .env.example .env
   ```

5. Generate application key:

   ```bash
   php artisan key:generate
   ```

6. Buat database MySQL dengan nama `db_cafe`.

7. Atur konfigurasi database pada file `.env`.

8. Jalankan migration:

   ```bash
   php artisan migrate
   ```

9. Install dependency frontend:

   ```bash
   npm install
   ```

10. Build aset frontend:

    ```bash
    npm run build
    ```

11. Jalankan aplikasi:

    ```bash
    php artisan serve
    ```

## Informasi Project

- **Nama Project:** Kedai Kopi Senja
- **Jenis Project:** Sistem Informasi Manajemen Kedai Kopi
- **Framework:** Laravel 13
- **Database:** MySQL
- **Platform:** Web dan API Backend
- **Status:** Pengembangan aplikasi web selesai, aplikasi Android pelanggan masih dalam tahap pengembangan.