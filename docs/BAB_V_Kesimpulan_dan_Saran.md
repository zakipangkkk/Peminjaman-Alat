# BAB V
# PENUTUP

Bab ini memuat kesimpulan menyeluruh mengenai hasil rancang bangun dan implementasi Sistem Informasi Peminjaman Alat (RODA / Lab Komputer), serta saran-saran konstruktif yang dapat dijadikan sebagai acuan untuk pengembangan aplikasi pada versi mendatang.

---

## V.1 Kesimpulan

Berdasarkan seluruh tahapan perancangan, implementasi, dan pengujian sistem yang telah dilakukan pada aplikasi web Sistem Informasi Peminjaman Alat, dapat diambil beberapa kesimpulan sebagai berikut:

1. **Digitalisasi Pengelolaan Inventaris dan Peminjaman:**  
   Aplikasi berhasil mentransformasi proses pencatatan peminjaman alat yang sebelumnya dilakukan secara manual (pembukuan fisik atau formulir kertas) menjadi sistem berbasis web terkomputerisasi yang terpusat. Hal ini meminimalisasi risiko kesalahan pencatatan, kehilangan arsip data, serta duplikasi data peminjaman.

2. **Efektivitas Manajemen Multi-Pengguna (Role-Based Access Control):**  
   Penerapan tiga level hak akses pengguna—yaitu Administrator, Petugas, dan User (Peminjam)—berjalan dengan baik sesuai tugas pokok dan fungsinya. Admin memiliki kendali penuh atas data master dan akun; Petugas dapat fokus pada verifikasi booking lapangan, validasi fisik alat, serta penetapan denda; sedangkan User dapat dengan mudah mengajukan peminjaman secara mandiri.

3. **Kemudahan Pengajuan Multi-Item Melalui Fitur Keranjang (Cart):**  
   Penyediaan fitur keranjang peminjaman alat terbukti meningkatkan efisiensi proses permohonan. Pengguna dapat memilih dan meminjam lebih dari satu jenis atau unit alat sekaligus dalam satu kali transaksi checkout peminjaman tanpa perlu menginput formulir berulang kali.

4. **Transparansi dan Pemantauan Status Secara Real-Time:**  
   Alur status peminjaman (*Pending* → *Approved* / *Rejected* → *Completed*) memberikan transparansi informasi bagi peminjam mengenai status pengajuannya. Di sisi lain, sistem secara otomatis memperbarui ketersediaan stok fisik alat saat peminjaman disetujui maupun setelah alat dikembalikan.

5. **Pengendalian Disiplin Peminjam dan Pertanggungjawaban Melalui Laporan:**  
   Fitur pencatatan pengembalian yang terintegrasi dengan kalkulasi denda keterlambatan/kerusakan membantu meningkatkan kedisiplinan peminjam dalam mengembalikan alat tepat waktu. Selain itu, fitur cetak laporan memudahkan petugas dalam membuat berkas dokumentasi fisik untuk keperluan audit dan arsip berkala laboratorium.

---

## V.2 Saran Pengembangan Aplikasi

Meskipun sistem yang dibangun telah memenuhi kebutuhan fungsional inti peminjaman alat, masih terdapat beberapa peluang peningkatan untuk menyempurnakan performa, keamanan, dan pengalaman pengguna di masa depan. Beberapa saran pengembangan yang direkomendasikan adalah:

1. **Integrasi Gateway Notifikasi Otomatis (WhatsApp API / Email Notification):**  
   Perlu dikembangkan integrasi layanan pesan otomatis seperti WhatsApp Gateway (misal: Fonnte/Twilio) atau notifikasi email. Fitur ini akan memberikan pemberitahuan instan saat permohonan peminjaman disetujui/ditolak, serta berfungsi sebagai pengingat otomatis (reminder H-1 atau pada hari H) kepada peminjam sebelum batas waktu pengembalian berakhir guna mencegah keterlambatan.

2. **Implementasi Pemindai Kode QR / Barcode Fisik Alat:**  
   Disarankan untuk menambahkan sistem pelabelan QR Code atau Barcode pada setiap unit fisik alat serta kartu identitas peminjam. Dengan fitur pemindaian kamera pada antarmuka petugas, proses serah terima barang dan verifikasi pengembalian dapat berlangsung jauh lebih cepat dan akurat tanpa perlu pencarian data secara manual.

3. **Integrasi Payment Gateway Digital untuk Pembayaran Denda:**  
   Untuk memfasilitasi transaksi pembayaran denda keterlambatan atau ganti rugi kerusakan secara non-tunai, aplikasi dapat dihubungkan dengan Payment Gateway (seperti Midtrans, Xendit, atau QRIS dinamis). Hal ini akan meningkatkan akuntabilitas keuangan dan memudahkan rekapitulasi kas denda.

4. **Fitur Unggah Bukti Dokumentasi Kondisi Fisik Alat (Foto Kondisi Sebelum & Sesudah):**  
   Menambahkan fitur unggah foto kondisi fisik alat saat diambil dan saat dikembalikan oleh peminjam. Dokumentasi visual ini sangat berguna sebagai bukti otentik jika terjadi perselisihan mengenai klaim kerusakan alat antara pihak laboratorium dan peminjam.

5. **Pengembangan Aplikasi Mobile (Progressive Web App / Native Mobile App):**  
   Mengembangkan aplikasi ke arah Progressive Web App (PWA) atau aplikasi mobile Android/iOS agar peminjam dapat mengakses katalog, keranjang, dan memantau status peminjaman dengan lebih fleksibel melalui perangkat telepon pintar mereka.

6. **Penyediaan Modul Analitik dan Prediksi Pengadaan Alat (Dashboard Visual):**  
   Menambahkan visualisasi grafik analitik yang memetakan tren alat yang paling sering dipinjam, rata-rata durasi peminjaman, dan estimasi waktu keausan/pemeliharaan alat. Informasi ini akan sangat membantu pihak manajemen laboratorium dalam merencanakan anggaran pengadaan barang baru secara tepat sasaran.
