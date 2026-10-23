```blade
@extends('layouts.master')

@section('title', 'Dashboard Admin')

@section('content')

<div class="topbar">
    <div>
        <div class="eyebrow">
            Ringkasan · Hari ini
        </div>

        <h1>Dashboard</h1>
    </div>

    <div class="topbar-right">
        {{-- Tombol aksi bisa ditambahkan di sini --}}
    </div>
</div>


{{-- STATISTIK --}}
<div class="stats">

    <div class="stat-card">
        <div class="label">
            Alat tersedia
        </div>

        <div class="value">
            {{ $alatTersedia ?? 0 }}
        </div>

        <div class="delta">
            Total unit yang tersedia
        </div>
    </div>

    <div class="stat-card">
        <div class="label">
            Sedang dipinjam
        </div>

        <div class="value">
            {{ $alatDipinjam ?? 0 }}
        </div>

        <div class="delta">
            Peminjaman yang masih berlangsung
        </div>
    </div>

    <div class="stat-card">
        <div class="label">
            Total jenis alat
        </div>

        <div class="value">
            {{ $totalAlat ?? 0 }}
        </div>

        <div class="delta">
            Jenis alat terdaftar
        </div>
    </div>

    <div class="stat-card">
        <div class="label">
            Total pengguna
        </div>

        <div class="value">
            {{ $totalUser ?? 0 }}
        </div>

        <div class="delta">
            Pengguna terdaftar
        </div>
    </div>

</div>


{{-- PEMINJAMAN TERBARU --}}
<div class="panel">

    <div class="panel-head">
        <h2>Peminjaman Terbaru</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Peminjam</th>
                <th>Nama Alat</th>
                <th>Tanggal Pinjam</th>
                <th>Rencana Kembali</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($peminjamanTerbaru ?? [] as $peminjaman)
                <tr>
                    <td>
                        #{{ $peminjaman->id }}
                    </td>

                    <td>
                        {{ $peminjaman->user->username ?? '-' }}
                    </td>

                    <td>
                        @forelse ($peminjaman->detail as $detail)
                            <div style="margin-bottom: 5px;">
                                {{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                                ({{ $detail->jumlah }} unit)
                            </div>
                        @empty
                            -
                        @endforelse
                    </td>

                    <td>
                        {{ $peminjaman->tanggal_mulai
                            ? $peminjaman->tanggal_mulai->format('d-m-Y')
                            : '-' }}
                    </td>

                    <td>
                        {{ $peminjaman->tanggal_selesai
                            ? $peminjaman->tanggal_selesai->format('d-m-Y')
                            : '-' }}
                    </td>

                    <td>
                        <span class="badge">
                            {{ ucfirst($peminjaman->status ?? '-') }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">
                        Belum ada data peminjaman.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
```