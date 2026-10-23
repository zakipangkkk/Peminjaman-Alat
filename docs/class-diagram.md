# Diagram Class — Sistem Peminjaman Alat

> Database: `db_peminjaman`

## Class Diagram (Mermaid)

```mermaid
classDiagram
    direction LR

    class User {
        +bigint id
        +string username
        +string email
        +string password
        +string no_telfon
        +enum role
        +timestamp created_at
        +timestamp updated_at
        --
        role: user | admin | petugas
    }

    class Kategori {
        +bigint id
        +string nama_kategori
        +timestamp created_at
        +timestamp updated_at
    }

    class Alat {
        +bigint id
        +bigint kategori_id
        +string nama_alat
        +int jumlah
        +string foto
        +timestamp created_at
        +timestamp updated_at
    }

    class Booking {
        +bigint id
        +bigint user_id
        +date tanggal_mulai
        +date tanggal_selesai
        +enum status
        +text catatan
        +timestamp created_at
        +timestamp updated_at
        --
        status: pending | approved | rejected | completed
    }

    class DetailBooking {
        +bigint id
        +bigint booking_id
        +bigint alat_id
        +int jumlah
        +timestamp created_at
        +timestamp updated_at
    }

    class Pengembalian {
        +bigint id
        +bigint booking_id
        +date tanggal_kembali
        +decimal denda
        +string keterangan
        +string status
        +timestamp created_at
        +timestamp updated_at
    }

    class LogAktivitas {
        +bigint id
        +bigint user_id
        +string aktivitas
        +datetime waktu_aktivitas
        +timestamp created_at
        +timestamp updated_at
    }

    %% Relasi antar kelas
    Kategori "1" --> "0..*" Alat : memiliki
    User "1" --> "0..*" Booking : membuat
    Booking "1" --> "1..*" DetailBooking : berisi
    Alat "1" --> "0..*" DetailBooking : digunakan_dalam
    Booking "1" --> "0..1" Pengembalian : menghasilkan
    User "1" --> "0..*" LogAktivitas : mencatat
```

---

## Penjelasan Relasi

| Relasi | Tipe | Keterangan |
|--------|------|------------|
| `Kategori` → `Alat` | One-to-Many | Satu kategori memiliki banyak alat |
| `User` → `Booking` | One-to-Many | Satu user dapat membuat banyak booking |
| `Booking` → `DetailBooking` | One-to-Many | Satu booking memiliki banyak detail alat |
| `Alat` → `DetailBooking` | One-to-Many | Satu alat dapat ada di banyak detail booking |
| `Booking` → `Pengembalian` | One-to-One | Satu booking memiliki satu pengembalian |
| `User` → `LogAktivitas` | One-to-Many | Satu user mencatat banyak log aktivitas |

---

## Deskripsi Entitas

### User
Menyimpan data pengguna sistem dengan tiga peran:
- `user` — peminjam alat
- `admin` — administrator
- `petugas` — staf lapangan

### Kategori
Pengelompokan alat berdasarkan jenis/kategori.

### Alat
Data alat yang tersedia untuk dipinjam, terhubung ke kategori dan memiliki informasi stok (`jumlah`).

### Booking
Transaksi peminjaman yang dibuat oleh user. Alur status:
```
pending → approved → completed
pending → rejected
```

### DetailBooking
Tabel pivot yang mencatat alat-alat beserta jumlahnya dalam satu booking.

### Pengembalian
Data pengembalian alat termasuk tanggal kembali dan perhitungan denda keterlambatan.

### LogAktivitas
Audit trail untuk mencatat semua aktivitas user di sistem.
