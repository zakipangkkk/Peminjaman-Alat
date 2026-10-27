# Sistem Peminjaman Alat Laboratorium Komputer

## 📌 Pengenalan Sistem

Sistem Peminjaman Alat Laboratorium Komputer merupakan aplikasi berbasis web yang dirancang untuk mempermudah proses peminjaman dan pengembalian alat laboratorium komputer di lingkungan sekolah. Sistem ini dibuat untuk membantu pengelolaan data alat, data pengguna, kategori alat, transaksi peminjaman, serta pengembalian alat agar lebih terstruktur dan efisien.

Aplikasi ini memiliki tiga hak akses pengguna, yaitu **Admin, Petugas, dan Siswa**. Admin bertugas mengelola data alat, kategori, pengguna, peminjaman, pengembalian, serta laporan. Petugas bertugas memverifikasi transaksi peminjaman dan pengembalian alat. Sementara itu, siswa dapat melihat daftar alat yang tersedia, mengajukan peminjaman melalui keranjang, dan melihat riwayat peminjaman.

Dengan adanya sistem ini, proses peminjaman alat diharapkan menjadi lebih mudah, tertata, dan mengurangi kesalahan dalam pencatatan data.

## ✨ Fitur Sistem

### 👨‍💼 Admin
- Mengelola data alat laboratorium komputer.
- Mengelola kategori alat.
- Mengelola data pengguna.
- Melihat dan mengelola data peminjaman.
- Mengelola data pengembalian.
- Melihat laporan peminjaman dan pengembalian.

### 🧑‍🔧 Petugas
- Melihat data peminjaman.
- Memverifikasi peminjaman alat.
- Memverifikasi pengembalian alat.
- Membantu proses pengelolaan transaksi peminjaman.

### 🎓 Siswa
- Melihat daftar alat yang tersedia.
- Melihat detail alat.
- Memilih alat melalui keranjang peminjaman.
- Mengajukan peminjaman alat.
- Melihat riwayat peminjaman.

## 🔐 Akun Login

Gunakan akun berikut untuk mencoba sistem:

| Role | Username | Password |
|---|---|---|
| Siswa | `siswa` | `12345678` |
| Admin | `admin` | `admin123` |
| Petugas | `petugas` | `petugas123` |

**Catatan:** Akun di atas merupakan akun demo. Pastikan akun sudah tersedia di database sebelum mencoba login.

## 🛠️ Teknologi yang Digunakan

- **Framework:** Laravel
- **Bahasa Pemrograman:** PHP
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript, dan Blade
- **Development Environment:** Laragon

## 🚀 Instalasi dan Menjalankan Sistem

1. Clone repository GitHub:

   ```bash
   git clone https://github.com/USERNAME/NAMA-REPOSITORY.git
   ```

2. Masuk ke folder proyek:

   ```bash
   cd NAMA-REPOSITORY
   ```

3. Install dependensi Laravel:

   ```bash
   composer install
   ```

4. Salin file konfigurasi:

   ```bash
   cp .env.example .env
   ```

   Pada Windows, kamu juga dapat menyalin `.env.example` secara manual menjadi `.env`.

5. Buat database MySQL dengan nama `db_peminjaman`, kemudian sesuaikan konfigurasi database di file `.env`.

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_peminjaman
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Generate application key:

   ```bash
   php artisan key:generate
   ```
7. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

8. Buka aplikasi melalui browser:

    ```text
    http://127.0.0.1:8000
    ```

## 🎯 Tujuan Sistem

Sistem ini bertujuan untuk membantu sekolah dalam mengelola peminjaman alat laboratorium komputer secara digital, mempermudah pemantauan ketersediaan alat, serta meningkatkan ketertiban administrasi peminjaman dan pengembalian.

---

**Dikembangkan sebagai proyek pembelajaran** untuk penerapan sistem informasi berbasis web menggunakan Laravel dan MySQL.
