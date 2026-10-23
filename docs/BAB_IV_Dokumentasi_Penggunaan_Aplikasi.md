# BAB IV
# DOKUMENTASI PENGGUNAAN APLIKASI
### Sistem Informasi Peminjaman Alat (RODA / Lab Komputer)

---

Bab ini menjelaskan petunjuk teknis operasional dan dokumentasi tata cara penggunaan aplikasi **Sistem Informasi Peminjaman Alat (RODA / Laboratorium Komputer)**. Panduan ini disusun berdasarkan hak akses (*role*) masing-masing aktor yang terlibat di dalam sistem, yaitu:
1. **Level Admin (Administrator)**
2. **Level User (Peminjam)**
3. **Level Petugas (Staf Lapangan / Operator)**

---

## IV.1 Level Admin

Administrator (Admin) memiliki wewenang tertinggi dalam mengelola data master sistem, mengonfigurasi kategori dan inventaris alat, mengelola akun seluruh pengguna, serta mengawasi seluruh riwayat transaksi peminjaman dan pengembalian yang terjadi dalam sistem.

### IV.1.1 Halaman Login Administrator
Untuk masuk ke sistem, Administrator harus melakukan autentikasi kredensial terlebih dahulu melalui portal login terpusat.

**Langkah-langkah login Administrator:**
1. Buka peramban (*web browser*) dan akses URL portal aplikasi pada halaman login (`/login`).
2. Masukkan **Username** akun Administrator pada kolom input username yang tersedia.
3. Masukkan **Password** yang valid pada kolom kata sandi.
4. Klik tombol **Login** atau **Masuk**. Sistem akan memvalidasi akun. Jika kredensial sesuai dengan role `admin`, sistem akan mengarahkan pengguna secara otomatis ke halaman **Dashboard Administrator** (`/admin`).

> **[Gambar 4.1 Antarmuka Form Login Administrator]**  
> *(Tempat tangkapan layar form login dengan isian username, password, dan tombol masuk)*

| No | Elemen Antarmuka | Fungsi / Deskripsi |
| :---: | :--- | :--- |
| 1 | Field Username | Form isian untuk memasukkan nama pengguna (*username*) akun admin terdaftar. |
| 2 | Field Password | Form isian kata sandi yang disamarkan dengan enkripsi asteris (*). |
| 3 | Tombol Login | Mengeksekusi proses validasi autentikasi kredensial ke database. |
| 4 | Tautan Registrasi | Navigasi bagi pengguna umum yang belum memiliki akun untuk mendaftar. |

---

### IV.1.2 Halaman Dashboard Administrator
Halaman Dashboard Administrator (`/admin`) merupakan pusat kendali ringkasan metrik statistik aplikasi. Pada halaman ini, Admin dapat memantau indikator operasional secara real-time seperti total data alat inventaris, jumlah peminjaman aktif, transaksi pengembalian, dan jumlah user terdaftar.

> **[Gambar 4.2 Antarmuka Dashboard Administrator]**  
> *(Tempat tangkapan layar panel dashboard admin berisi kartu ringkasan metrik dan menu sidebar)*

**Menu navigasi pada Sidebar Admin:**
- **Dashboard:** Menampilkan ringkasan statistik dan rekapitulasi data global sistem.
- **Alat:** Mengakses modul inventaris barang/alat untuk mengelola data alat yang tersedia.
- **Penyewaan / Booking:** Mengakses seluruh daftar permohonan peminjaman alat yang masuk.
- **Pengembalian:** Mengakses daftar pengembalian alat, denda keterlambatan, dan status verifikasi.
- **Kategori:** Mengelola kelompok klasifikasi kategori alat (misal: Komputer, Jaringan, Multimedia).
- **Pelanggan / User:** Mengelola seluruh akun pengguna sistem, termasuk perubahan hak akses (*role*).
- **Keluar / Logout:** Mengakhiri sesi akses administrator dan keluar dari sistem dengan aman.

---

### IV.1.3 Pengelolaan Kategori Alat (CRUD Kategori)
Modul Kategori (`/admin/kategori`) digunakan untuk mengorganisasi inventaris alat agar mempermudah proses pencarian dan pelaporan.

1. Pilih menu **Kategori** pada sidebar admin untuk membuka tabel daftar kategori yang ada.
2. **Tambah Kategori Baru:** Klik tombol **Tambah Kategori**, masukkan nama kategori baru pada formulir isian, kemudian klik tombol **Simpan**.
3. **Ubah Kategori:** Klik tombol **Edit** (ikon pensil) pada baris kategori yang bersangkutan, ubah nama kategori, lalu tekan tombol **Update**.
4. **Hapus Kategori:** Klik tombol **Hapus** (ikon tempat sampah) dan lakukan konfirmasi dialog konfirmasi penghapusan.

> **[Gambar 4.3 Antarmuka Manajemen Kategori Alat]**  
> *(Tempat tangkapan layar tabel kategori dan form penambahan kategori baru)*

---

### IV.1.4 Pengelolaan Data Alat & Inventaris Stok
Modul Alat (`/admin/alat`) berfungsi untuk mengelola seluruh data inventaris alat yang dapat dipinjam oleh pengguna. Admin memiliki kendali penuh atas spesifikasi, stok fisik, dan dokumentasi visual (foto alat).

**Prosedur penambahan dan pembaruan alat:**
1. Buka menu **Alat** pada sidebar, kemudian klik tombol **Tambah Alat** (`/admin/alat/create`).
2. Isi **Nama Alat** secara jelas (misal: "Proyektor Epson EB-X500", "Kabel Tester RJ45").
3. Pilih **Kategori Alat** yang sesuai melalui menu dropdown pilihan.
4. Masukkan **Jumlah Stok** alat fisik yang siap dipinjamkan.
5. Unggah **Foto Alat** resmi (format `.jpg`, `.jpeg`, atau `.png`) untuk memudahkan peminjam mengenali barang.
6. Klik tombol **Simpan Data**. Data alat akan langsung muncul pada katalog publik pengguna.
7. Admin juga dapat melakukan pembaruan stok (**Edit**) jika ada penambahan barang baru atau pengurangan barang rusak/hilang.

> **[Gambar 4.4 Antarmuka Form Tambah & Edit Data Alat]**  
> *(Tempat tangkapan layar form pengisian data alat baru beserta upload berkas gambar)*

---

### IV.1.5 Pengelolaan Transaksi Booking (Peminjaman)
Menu Penyewaan / Booking (`/admin/booking`) menampilkan seluruh rekaman transaksi peminjaman yang diajukan oleh pengguna. Admin dapat memfilter daftar berdasarkan status: Menunggu Konfirmasi (*Pending*), Disetujui (*Approved*), Ditolak (*Rejected*), dan Selesai (*Completed*).

1. Pilih menu **Penyewaan** pada sidebar admin.
2. Periksa detail permohonan peminjaman: identitas peminjam, nama alat, kuantitas, tanggal mulai pinjam, tanggal selesai, dan catatan keperluan.
3. Admin dapat memberikan aksi langsung: klik **Setujui** untuk menyetujui peminjaman, atau klik **Tolak** jika kondisi alat tidak memungkinkan.
4. Bila peminjam telah mengembalikan alat secara langsung kepada Admin, Admin dapat menekan tombol **Kembali** untuk memproses pengembalian alat ke inventaris.

> **[Gambar 4.5 Antarmuka Tabel Transaksi Peminjaman (Admin)]**  
> *(Tempat tangkapan layar tabel daftar booking peminjaman dengan tombol aksi persetujuan)*

---

### IV.1.6 Pengelolaan Data Pengguna (User Management)
Modul Pelanggan / User (`/admin/user`) memberikan akses bagi Administrator untuk mengelola seluruh akun pengguna dalam sistem database.

1. Admin dapat melihat daftar lengkap user beserta username, email, nomor telepon, dan hak akses (*role*).
2. Admin dapat menambahkan akun baru secara manual untuk staf atau petugas melalui tombol **Tambah User**.
3. Admin dapat mengubah role pengguna (misal dari `user` menjadi `petugas` atau `admin`).
4. Admin dapat melakukan reset password atau menghapus akun yang sudah tidak aktif.

> **[Gambar 4.6 Antarmuka Pengelolaan Akun Pengguna (User)]**  
> *(Tempat tangkapan layar daftar tabel pengguna dan form manajemen role hak akses)*

---

## IV.2 Level User (Peminjam)

Aktor User (Peminjam) adalah anggota, siswa, mahasiswa, atau pengguna yang memerlukan alat laboratorium/operasional. Pengguna pada level ini memiliki akses untuk menjelajahi katalog alat, memilih barang menggunakan fitur keranjang, mengajukan peminjaman secara mandiri, dan memantau status persetujuan secara transparan.

### IV.2.1 Registrasi Akun Peminjam Baru
Bagi calon peminjam yang belum memiliki akun terdaftar, sistem menyediakan fasilitas registrasi mandiri melalui URL `/register`.

1. Akses halaman pendaftaran dengan menekan tombol **Daftar Akun Baru** pada halaman login.
2. Isi **Username** unik yang akan digunakan untuk masuk ke sistem.
3. Masukkan **Alamat Email** aktif yang valid untuk identifikasi pengguna.
4. Masukkan **Nomor Telepon/WhatsApp** yang dapat dihubungi oleh petugas untuk konfirmasi fisik alat.
5. Tentukan **Kata Sandi** (minimal 6 karakter) dan ketikkan ulang pada kolom Konfirmasi Password.
6. Klik tombol **Daftar Sekarang**. Sistem otomatis mendaftarkan akun dengan hak akses role `user` dan mengarahkan kembali ke halaman login.

> **[Gambar 4.7 Antarmuka Form Registrasi Pengguna Baru]**  
> *(Tempat tangkapan layar form pendaftaran akun user dengan isian data lengkap dan konfirmasi password)*

---

### IV.2.2 Menjelajahi Katalog Alat & Detail Spesifikasi
Setelah berhasil login, peminjam akan diarahkan ke halaman katalog alat (`/alat`). Pada katalog ini, peminjam dapat melihat visualisasi barang, status ketersediaan unit, serta kategori alat.

1. Peminjam dapat menelusuri daftar alat atau memfilter berdasarkan kategori yang diinginkan.
2. Klik pada kartu alat untuk melihat informasi detail (`/alat/{id}`) seperti kondisi fisik, stok yang tersisa, dan deskripsi fungsi alat.
3. Jika alat ingin dipinjam, pengguna dapat langsung menekan tombol **Tambah ke Keranjang** atau tombol **Pinjam Langsung**.

> **[Gambar 4.8 Antarmuka Katalog Alat & Halaman Detail Alat]**  
> *(Tempat tangkapan layar grid katalog alat laboratorium dengan foto dan stok unit)*

---

### IV.2.3 Mengelola Keranjang Peminjaman Alat
Fitur Keranjang (`/keranjang`) memungkinkan peminjam mengumpulkan beberapa alat sekaligus dalam satu kali pengajuan transaksi tanpa harus melakukan peminjaman berulang secara terpisah.

1. Buka menu **Keranjang** melalui tautan navigasi bagian atas (navbar).
2. Pada tabel keranjang, peminjam dapat melihat daftar alat yang telah dipilih beserta kuantitas pinjam.
3. Peminjam dapat mengubah jumlah pinjam (kuantitas) sesuai kebutuhan dengan memperhatikan batas stok yang tersedia.
4. Peminjam dapat menghapus item alat tertentu dengan menekan tombol **Hapus** dari keranjang.
5. Klik tombol **Checkout Peminjaman** untuk melangkah ke tahap pengisian data formulir booking.

> **[Gambar 4.9 Antarmuka Keranjang Peminjaman Alat]**  
> *(Tempat tangkapan layar tabel item keranjang peminjaman dengan kuantitas dan tombol checkout)*

---

### IV.2.4 Pengajuan Transaksi Peminjaman (Checkout Booking)
Pada form permohonan peminjaman (`/booking/create` atau `/keranjang/checkout`), peminjam wajib menentukan periode peminjaman secara jelas.

1. Tentukan **Tanggal Mulai Pinjam** (tanggal kapan alat akan diambil di laboratorium/kantor).
2. Tentukan **Tanggal Selesai Pinjam** (tanggal batas akhir alat wajib dikembalikan).
3. Isi **Catatan / Keperluan Peminjaman** (misalnya: "Praktikum Jaringan Komputer Modul 3" atau "Seminar Mahasiswa").
4. Klik tombol **Kirim Pengajuan Peminjaman**. Sistem akan mencatat transaksi dengan status awal `pending` dan mengurangi kuota antrean alat.

> **[Gambar 4.10 Antarmuka Formulir Pengajuan Peminjaman (Booking)]**  
> *(Tempat tangkapan layar formulir pemilihan tanggal peminjaman, tanggal pengembalian, dan isian catatan)*

---

### IV.2.5 Pemantauan Riwayat & Status Peminjaman
Peminjam dapat memantau perkembangan status verifikasi pengajuannya melalui menu **Riwayat** (`/booking`).

| No | Status Peminjaman | Arti & Keterangan |
| :---: | :--- | :--- |
| 1 | **Pending (Kuning)** | Pengajuan telah masuk ke sistem dan sedang menunggu peninjauan/verifikasi oleh Petugas atau Admin. |
| 2 | **Approved (Hijau)** | Pengajuan telah **DISETUJUI**. Peminjam dapat mendatangi pos petugas untuk mengambil fisik alat sesuai tanggal mulai. |
| 3 | **Rejected (Merah)** | Pengajuan **DITOLAK** karena alasan tertentu (misal stok fisik tidak memadai atau keperluan bentrok). |
| 4 | **Completed (Biru)** | Alat telah selesai dikembalikan kepada petugas, diperiksa kondisinya, dan transaksi dinyatakan tuntas. |

> **[Gambar 4.11 Antarmuka Riwayat Peminjaman User]**  
> *(Tempat tangkapan layar halaman riwayat peminjaman dengan badge status berwarna Pending, Approved, Completed)*

---

## IV.3 Level Petugas

Petugas (Staf Lapangan / Operator Alat) adalah garda terdepan operasional laboratorium yang bertanggung jawab memverifikasi kelayakan pengajuan peminjaman, menyerahkan fisik alat kepada peminjam, memeriksa kondisi fisik alat saat dikembalikan, menetapkan denda (jika terjadi keterlambatan atau kerusakan), serta mencetak laporan pertanggungjawaban operasional.

### IV.3.1 Login & Dashboard Operasional Petugas
Petugas masuk menggunakan akun dengan hak akses role `petugas` melalui halaman login (`/login`). Setelah autentikasi berhasil, sistem mengarahkan petugas langsung ke **Dashboard Petugas** (`/petugas`).

1. Dashboard Petugas menampilkan indikator tugas harian: jumlah pengajuan baru yang butuh verifikasi segera, jumlah alat yang sedang berada di tangan peminjam, dan jadwal pengembalian alat hari ini.
2. Petugas memiliki baris menu navigasi praktis: **Dashboard**, **Verifikasi (Booking)**, **Pengembalian**, dan **Laporan**.

> **[Gambar 4.12 Antarmuka Dashboard Operasional Petugas]**  
> *(Tempat tangkapan layar dashboard khusus role petugas dengan menu navigasi cepat dan ringkasan antrean tugas)*

---

### IV.3.2 Verifikasi & Validasi Pengajuan Peminjaman
Menu Verifikasi (`/petugas/booking`) adalah tempat kerja utama petugas untuk memproses antrean booking peminjaman dari pengguna.

1. Buka menu **Verifikasi**. Tabel akan menampilkan daftar permohonan pinjam dengan status `pending`.
2. Petugas mengecek detail informasi: Nama peminjam, kontak nomor telepon, daftar alat yang diminta, kuantitas item, serta rentang tanggal peminjaman.
3. Petugas mengecek ketersediaan fisik alat di rak inventaris laboratorium.
4. **Jika disetujui:** Petugas mengklik tombol **Setujui** (Aksi ACC). Sistem akan mengubah status booking menjadi `approved`, memotong stok alat, dan mengizinkan peminjam mengambil barang.
5. **Jika ditolak:** Petugas mengklik tombol **Tolak**. Sistem akan memperbarui status menjadi `rejected` dan membatalkan pesanan.

> **[Gambar 4.13 Antarmuka Menu Verifikasi Booking Petugas]**  
> *(Tempat tangkapan layar tabel verifikasi booking dengan tombol aksi Setujui hijau dan Tolak merah)*

---

### IV.3.3 Pemrosesan Pengembalian Fisik Alat & Kalkulasi Denda
Ketika peminjam selesai menggunakan alat dan mengembalikannya ke laboratorium, Petugas wajib mencatat transaksi pengembalian melalui menu **Pengembalian** (`/petugas/pengembalian`).

1. Petugas menerima fisik alat dari peminjam dan mencocokkan kelengkapan unit sesuai data booking.
2. Petugas memeriksa kondisi fisik alat (apakah ada cacat, pecah, kelengkapan kabel hilang, atau kerusakan fungsi).
3. Petugas memeriksa tanggal pengembalian riil terhadap tanggal jatuh tempo selesai peminjaman.
4. Bila terjadi keterlambatan atau kerusakan, petugas menginput nominal **Denda** dan **Catatan Keterangan** pada form pengembalian.
5. Petugas menekan tombol konfirmasi **Selesai / Kembali**. Sistem secara otomatis memperbarui status transaksi menjadi `completed`, mencatat riwayat ke log sistem, dan mengembalikan kuantitas stok alat ke inventaris ketersediaan.

> **[Gambar 4.14 Antarmuka Form & Tabel Pengembalian Alat Petugas]**  
> *(Tempat tangkapan layar halaman pencatatan pengembalian alat dengan kolom input tanggal riil, denda, dan catatan)*

---

### IV.3.4 Rekapitulasi & Cetak Dokumen Laporan Peminjaman
Modul Laporan (`/petugas/laporan`) berfungsi untuk menyusun rekapan transaksi peminjaman dan pengembalian dalam jangka waktu tertentu yang dapat diekspor atau dicetak sebagai dokumen pertanggungjawaban fisik.

1. Pilih menu **Laporan** pada navigasi menu petugas.
2. Petugas dapat memfilter laporan berdasarkan rentang tanggal tertentu atau status peminjaman.
3. Tabel menampilkan rangkuman data: Kode Peminjaman, Nama Peminjam, Rincian Alat, Tanggal Pinjam, Tanggal Pengembalian, Total Denda, dan Status Akhir.
4. Klik tombol **Cetak Laporan** (`/petugas/laporan/cetak`). Sistem akan membuka tampilan ramah cetak (*print-friendly*) yang siap diekspor menjadi format PDF atau dicetak langsung ke kertas fisik sebagai lampiran laporan resmi.

> **[Gambar 4.15 Antarmuka Halaman Cetak Laporan Peminjaman & Pengembalian]**  
> *(Tempat tangkapan layar lembar dokumen cetak laporan resmi dengan kop surat, tabel rekapitulasi, dan kolom tanda tangan pengesahan)*

---

## IV.4 Matriks Hak Akses Fungsional Pengguna

Tabel berikut merangkum matriks perbandingan fungsionalitas dan hak akses antarmuka yang dimiliki oleh masing-masing aktor dalam aplikasi Sistem Informasi Peminjaman Alat:

| No | Modul / Fitur Fungsional | Hak Akses Aktor (Admin / Petugas / User) |
| :---: | :--- | :--- |
| 1 | Registrasi Akun Baru | User Mandiri (Role: User) |
| 2 | Autentikasi Login & Logout | Semua Aktor (Admin, Petugas, User) |
| 3 | Melihat Katalog & Detail Alat | Semua Aktor (Publik & Terautentikasi) |
| 4 | Fitur Keranjang Peminjaman | User (Peminjam) |
| 5 | Pengajuan Booking Peminjaman | User (Peminjam) |
| 6 | Monitoring Riwayat Pribadi | User (Peminjam) |
| 7 | Kelola Master Kategori Alat (CRUD) | Administrator |
| 8 | Kelola Master Data Alat & Stok (CRUD) | Administrator |
| 9 | Verifikasi & Validasi Booking (ACC/Tolak) | Petugas & Administrator |
| 10 | Pencatatan Fisik Pengembalian & Denda | Petugas & Administrator |
| 11 | Manajemen Akun Seluruh Pengguna (CRUD) | Administrator |
| 12 | Pencetakan Dokumen Rekapitulasi Laporan | Petugas & Administrator |
