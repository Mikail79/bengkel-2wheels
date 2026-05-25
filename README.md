# Bengkel 2Wheels Management System

Sistem Informasi Manajemen Bengkel 2Wheels adalah aplikasi berbasis web yang dibangun menggunakan framework Laravel. Sistem ini dirancang untuk memudahkan operasional bengkel motor, mulai dari pengelolaan inventori, penerimaan barang dari supplier, manajemen pelanggan, hingga pelayanan di service desk.

## Fitur Utama

- **Manajemen Inventori**: Pencatatan stok barang/suku cadang (Motor, Sparepart, dll).
- **Service Desk**: Modul untuk melayani pelanggan yang datang, mencatat keluhan, dan membuat tiket servis.
- **Inbound PO**: Pengelolaan barang masuk dari supplier ke gudang bengkel.
- **Manajemen Staff/Petugas**: Pengelolaan data mekanik dan admin yang bertugas di bengkel.
- **Manajemen Supplier**: Pencatatan dan pengelolaan data pemasok suku cadang.

## Persyaratan Sistem

Pastikan environment Anda memenuhi kebutuhan berikut:
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js & NPM (untuk compile aset frontend)

## Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal:

1. **Clone repository ini**
   ```bash
   git clone https://github.com/username-anda/bengkel-2wheels.git
   cd bengkel-2wheels
   ```

2. **Install dependensi PHP menggunakan Composer**
   ```bash
   composer install
   ```

3. **Install dependensi NPM dan build aset**
   ```bash
   npm install
   npm run build
   ```

4. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan konfigurasi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database (dan Seeding jika ada)**
   ```bash
   php artisan migrate --seed
   ```

7. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser pada `http://localhost:8000`.

## Lisensi

Proyek ini bersifat open-source dan dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).
