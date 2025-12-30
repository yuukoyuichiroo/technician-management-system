# 💼 Aplikasi Manajemen Jasa Teknisi Komputer

Aplikasi web untuk mengelola layanan jasa teknisi komputer dengan fitur lengkap CRUD, multiple jasa per transaksi, dan cetak nota PDF.

![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![Filament](https://img.shields.io/badge/Filament-3.x-orange)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## ✨ Fitur Utama

-   ✅ **Manajemen Jasa** - CRUD lengkap untuk data jasa
-   ✅ **Transaksi Multi-Jasa** - Tambahkan banyak jasa dalam satu transaksi
-   ✅ **Riwayat Pesanan** - Lihat semua pesanan dengan filter & pencarian
-   ✅ **Cetak Nota PDF** - Generate nota profesional
-   ✅ **Info Toko** - Kelola informasi toko untuk nota
-   ✅ **Responsive Design** - Tampilan optimal di PC & Mobile
-   ✅ **Status Tracking** - Track status pembayaran & pengerjaan
-   ✅ **Auto Calculate** - Hitung total otomatis

## 📋 Requirements

-   PHP >= 8.1
-   Composer
-   MySQL/MariaDB
-   Node.js & NPM
-   Git

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/technician-management-system.git
cd technician-management-system
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### 3. Konfigurasi Environment

```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Buat symbolic link untuk storage
php artisan storage:link
```

### 4. Setup Database

Edit file `.env` dan sesuaikan dengan database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jasa_teknisi
DB_USERNAME=root
DB_PASSWORD=
```

Buat database baru:

```sql
CREATE DATABASE jasa_teknisi;
```

### 5. Jalankan Migration & Seeder

```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder untuk data awal
php artisan db:seed
```

### 6. Buat User Admin

```bash
php artisan make:filament-user
```

Masukkan informasi:

-   **Name**: Admin
-   **Email**: admin@admin.com
-   **Password**: password (atau sesuai keinginan)

### 7. Build Assets

```bash
npm run build
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000/admin**

Login menggunakan kredensial yang dibuat di step 6.

## 📱 Cara Penggunaan

### 1. Setup Awal

#### a. Tambah Data Jasa

1. Login ke dashboard admin
2. Klik menu **"Jasa"** di sidebar
3. Klik tombol **"Create"**
4. Isi form:
    - Nama Jasa (contoh: "Instalasi Windows")
    - Harga (contoh: 150000)
5. Klik **"Create"**

#### b. Edit Info Toko

1. Klik menu **"Info Toko"** di sidebar
2. Klik tombol **"Edit"** pada data toko
3. Isi informasi:
    - Nama Toko
    - Nomor Telepon
    - Alamat
4. Klik **"Save Changes"**

### 2. Membuat Transaksi

1. Klik menu **"Transaksi"** di sidebar
2. Klik tombol **"Create"**
3. Isi **Informasi Pelanggan**:
    - Nama Pelanggan
    - Lokasi
4. Isi **Detail Jasa**:
    - Klik **"Tambah Jasa"** untuk menambah item
    - Pilih jasa dari dropdown
    - Tentukan jumlah
    - Subtotal akan otomatis terhitung
    - Ulangi untuk menambah jasa lain
5. Isi **Pembayaran**:
    - Tipe Pembayaran (Cash/Non Cash)
    - Status Pembayaran (Dibayar/Belum Dibayar)
    - Status Pengerjaan (Selesai/Belum Selesai)
6. Klik **"Create"**

### 3. Melihat Riwayat Pesanan

1. Klik menu **"Riwayat Pesanan"** di sidebar
2. Lihat semua transaksi yang ada
3. Gunakan filter untuk:
    - Status Pembayaran
    - Status Pengerjaan
4. Gunakan search untuk mencari pelanggan

### 4. Cetak Nota

Ada 2 cara cetak nota:

#### Dari Menu Transaksi:

1. Klik menu **"Transaksi"**
2. Pada baris transaksi, klik icon **printer** (🖨️)
3. Nota akan terbuka di tab baru dalam format PDF

#### Dari Menu Riwayat Pesanan:

1. Klik menu **"Riwayat Pesanan"**
2. Klik icon **printer** pada transaksi yang diinginkan
3. Nota akan terbuka di tab baru

Anda bisa:

-   **Download** nota sebagai PDF
-   **Print** langsung dari browser
-   **Save** sebagai gambar (screenshot)

### 5. Edit/Hapus Data

#### Edit Transaksi:

1. Klik menu **"Transaksi"**
2. Klik icon **edit** (✏️) pada transaksi
3. Ubah data yang diperlukan
4. Klik **"Save Changes"**

#### Hapus Transaksi:

1. Klik menu **"Transaksi"**
2. Klik icon **delete** (🗑️)
3. Konfirmasi penghapusan

_Note: Edit dan hapus juga tersedia untuk menu Jasa dan Info Toko_

## 📊 Struktur Database

### Tabel `jasas`

-   id
-   nama_jasa
-   harga
-   timestamps

### Tabel `transaksis`

-   id
-   nama_pelanggan
-   lokasi
-   total_harga
-   tipe_pembayaran (cash/non_cash)
-   status_pembayaran (dibayar/belum_dibayar)
-   status_pengerjaan (selesai/belum_selesai)
-   timestamps

### Tabel `transaksi_items`

-   id
-   transaksi_id (FK)
-   jasa_id (FK)
-   jumlah
-   harga_satuan
-   subtotal
-   timestamps

### Tabel `toko_infos`

-   id
-   nama_toko
-   nomor_telepon
-   alamat
-   timestamps

## 🛠️ Teknologi yang Digunakan

-   **Framework**: Laravel 10.x
-   **Admin Panel**: Filament 3.x
-   **Database**: MySQL/MariaDB
-   **PDF Generator**: DomPDF
-   **Frontend**: Tailwind CSS (via Filament)
-   **Icons**: Heroicons

## 📝 Tips & Troubleshooting

### Reset Data

Jika ingin reset semua data:

```bash
php artisan migrate:fresh --seed
php artisan make:filament-user
```

### Clear Cache

Jika ada masalah cache:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Permission Error (Linux/Mac)

```bash
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
```

### PDF Tidak Muncul

Pastikan folder `storage/app/public` sudah ter-link:

```bash
php artisan storage:link
```

### Error saat Migration

Drop database dan buat ulang:

```sql
DROP DATABASE jasa_teknisi;
CREATE DATABASE jasa_teknisi;
```

Kemudian jalankan migration lagi:

```bash
php artisan migrate --seed
```

## 🔐 Default Login

Setelah membuat user dengan `php artisan make:filament-user`:

-   **URL**: http://localhost:8000/admin
-   **Email**: sesuai yang dibuat
-   **Password**: sesuai yang dibuat

## 📱 Responsive Design

Aplikasi ini fully responsive dan dapat diakses dari:

-   💻 Desktop/Laptop
-   📱 Smartphone
-   📱 Tablet

Menu sidebar akan otomatis menjadi hamburger menu di mobile.

## 🤝 Contributing

Contributions, issues, dan feature requests sangat diterima!

1. Fork repository ini
2. Buat branch baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 License

Project ini menggunakan [MIT License](LICENSE)

## 👨‍💻 Author

**Yuukoyuichiroo**

-   GitHub: [@yuukoyuichiroo](https://github.com/yuukoyuichiroo)

## 🙏 Acknowledgments

-   [Laravel](https://laravel.com)
-   [Filament PHP](https://filamentphp.com)
-   [DomPDF](https://github.com/barryvdh/laravel-dompdf)

---

⭐ Jangan lupa beri star jika project ini membantu Anda!
