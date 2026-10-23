@extends('layouts.petugas')

@section('title', 'RODA - Verifikasi Peminjaman')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/petugas-booking.css') }}">
@endpush

<style>
    /* public/css/petugas-booking.css  —  khusus petugas/booking/index.blade.php */

:root { color-scheme: light; --bg:#EFE9DC; --ink:#1F1D1A; --muted:#6B645A; --amber:#E4A233; --red:#B3371F; --card:#F7F2E7; --ok:#2F7D4F; }

body { background: var(--bg); color: var(--ink); font-family: 'Work Sans', system-ui, sans-serif; line-height: 1.6; }

.petugas-booking { max-width: 1200px; margin: 0 auto; padding: 50px clamp(16px, 4vw, 40px) 90px; }
.petugas-booking h1 { font-family: 'Oswald', 'Arial Narrow', sans-serif; margin: 0; }
.petugas-booking :focus-visible { outline: 3px solid var(--amber); outline-offset: 3px; }

.eyebrow-plate { color: var(--red); font: 600 15px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; margin: 0 0 6px; }
.page-title { font-size: clamp(36px, 5vw, 56px); font-weight: 700; line-height: 1.05; margin-bottom: 12px; }
.page-sub { color: var(--muted); margin: 0 0 28px; }

.alert { padding: 14px 16px; margin-bottom: 24px; border: 2px solid var(--ink); }
.alert-success { background: #DDEBDD; border-color: var(--ok); color: #1E5535; font-weight: 500; }
.alert-error { background: #F8E3DC; border-color: var(--red); color: #7A2412; }

/* ---------- FILTER ---------- */
.chip-row, .pager { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 30px; }
.pager { margin: 28px 0 0; }
.chip { border: 2px solid var(--ink); background: transparent; color: var(--ink); padding: 8px 18px; font: 500 15px 'Work Sans', sans-serif; text-decoration: none; }
.chip.active { background: var(--ink); color: var(--bg); box-shadow: 4px 4px 0 var(--amber); }

/* ---------- TABEL ---------- */
.table-wrap { background: var(--card); border: 2px solid var(--ink); box-shadow: 8px 8px 0 var(--ink); overflow-x: auto; }
.booking-table { width: 100%; border-collapse: collapse; min-width: 820px; }
.booking-table th {
    text-align: left; background: var(--ink); color: #F7F2E7; padding: 12px 16px;
    font: 600 14px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase;
}
.booking-table td { padding: 16px; border-bottom: 2px dashed rgba(31, 29, 26, .35); vertical-align: top; }
.booking-table tr:last-child td { border-bottom: 0; }
.booking-table strong { display: block; }
.sub { display: block; color: var(--muted); font-size: 13px; margin-top: 2px; }

/* ---------- CAP STATUS ---------- */
.stamp { display: inline-block; padding: 3px 12px; border: 2px solid currentColor; font: 700 14px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; }
.stamp-pending   { color: #9A6A0B; background: #FBEBC8; border-color: var(--amber); }
.stamp-approved { color: var(--ok); }
.stamp-rejected   { color: var(--red); }
.stamp-completed   { color: var(--muted); }

/* ---------- AKSI ---------- */
.actions { display: flex; flex-wrap: wrap; align-items: flex-start; gap: 10px; }
.actions form, td form { margin: 0; }

.btn-act {
    display: inline-block; list-style: none; cursor: pointer; background: transparent; color: var(--ink);
    border: 2px solid var(--ink); padding: 6px 14px; font: 600 14px 'Work Sans', sans-serif;
}
.btn-act:hover { background: var(--amber); }
.btn-ok { background: var(--ink); color: #F7F2E7; box-shadow: 3px 3px 0 var(--amber); }
.btn-ok:hover { background: var(--ok); }
.btn-no { color: var(--red); border-color: var(--red); }
.btn-no:hover { background: var(--red); color: #F7F2E7; }
.btn-no.solid { background: var(--red); color: #F7F2E7; }

.reject summary::-webkit-details-marker { display: none; }
.reject[open] { width: 100%; }
.reject-form { margin-top: 10px; padding: 12px; border: 2px dashed var(--red); background: var(--bg); display: grid; gap: 8px; max-width: 320px; }
.reject-form label { font-size: 13px; font-weight: 600; }
.reject-form textarea { width: 100%; border: 2px solid var(--ink); background: var(--card); color: var(--ink); padding: 8px 10px; font: 500 14px 'Work Sans', sans-serif; resize: vertical; border-radius: 0; }

.empty-row { text-align: center; padding: 44px 16px !important; }
.empty-row strong { font: 600 24px 'Oswald', sans-serif; }

/* ---------- HP: tabel jadi kartu ---------- */
@media (max-width: 760px) {
    .booking-table { min-width: 0; }
    .booking-table thead { display: none; }
    .booking-table, .booking-table tbody, .booking-table tr, .booking-table td { display: block; width: 100%; }
    .booking-table tr { border-bottom: 2px solid var(--ink); padding: 8px 0; }
    .booking-table td { border: 0; padding: 8px 16px; }
    .booking-table td::before { content: attr(data-label); display: block; color: var(--muted); font-size: 12px; text-transform: uppercase; letter-spacing: .1em; }
}
@media (prefers-reduced-motion: reduce) { * { transition: none !important; } }

/* ---------- DAFTAR ALAT & FORM PENGEMBALIAN ---------- */
.item-list { list-style: none; margin: 0; padding: 0; display: grid; gap: 10px; }
.item-list strong { display: block; }
.reject-form input[type="date"], .reject-form input[type="number"] {
    width: 100%; border: 2px solid var(--ink); background: var(--card); color: var(--ink);
    padding: 7px 10px; font: 500 14px 'Work Sans', sans-serif; border-radius: 0;
}

/* ---------- MENU ATAS PETUGAS ---------- */
.petugas-menu { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 36px; padding-bottom: 18px; border-bottom: 2px solid var(--ink); }
.petugas-menu a { border: 2px solid var(--ink); color: var(--ink); padding: 7px 18px; font: 500 15px 'Work Sans', sans-serif; text-decoration: none; }
.petugas-menu a:hover { box-shadow: 3px 3px 0 var(--amber); }
.petugas-menu a.active { background: var(--ink); color: var(--bg); box-shadow: 4px 4px 0 var(--amber); }
/* ---------- TOMBOL LOGOUT ---------- */
.logout-form {
    margin-left: auto;
    display: flex;
    align-items: center;
}

.btn-logout {
    background: var(--red);
    color: #fff;
    border: 2px solid var(--ink);
    padding: 7px 18px;
    font: 600 15px 'Work Sans', sans-serif;
    cursor: pointer;
    box-shadow: 3px 3px 0 var(--ink);
    transition: .12s;
}

.btn-logout:hover {
    background: var(--ink);
    color: var(--bg);
    box-shadow: 3px 3px 0 var(--amber);
}

@media (max-width: 480px) {
    .logout-form {
        margin-left: 0;
        width: 100%;
    }
}
</style>

@section('content')

<main class="petugas-booking">


            <div style="display: flex; align-items: flex-start; flex-wrap: wrap; gap: 12px; margin-bottom: 36px;">

        <div style="flex: 1; min-width: 200px;">
            @include('petugas._menu')
        </div>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf

            <button type="submit" class="btn-logout"
                    onclick="return confirm('Apakah kamu yakin ingin logout?')">
                ↪ Logout
            </button>
        </form>

    </div>

    <p class="eyebrow-plate">PANEL PETUGAS · PEMINJAMAN ALAT</p>
    <h1 class="page-title">Verifikasi peminjaman</h1>
    <p class="page-sub">Setujui atau tolak pengajuan dari peminjam. Menyetujui akan mengurangi stok alat.</p>

    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-error" role="alert">{{ session('error') }}</div>
    @endif

    {{-- FILTER STATUS --}}
    <div class="chip-row" role="group" aria-label="Filter status">
        @foreach ([
            'pending'   => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected'   => 'Ditolak',
            'completed'   => 'Selesai',
            'semua'     => 'Semua',
        ] as $key => $label)
            <a href="{{ route('petugas.booking.index', ['status' => $key]) }}"
               class="chip {{ $status === $key ? 'active' : '' }}">
                {{ $label }} ({{ $jumlah[$key] }})
            </a>
        @endforeach
    </div>

    <div class="table-wrap">
        <table class="booking-table">
            <thead>
                <tr>
                    <th>Pemohon</th>
                    <th>Alat</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($bookings as $b)

                    @php
                        $mulai = \Carbon\Carbon::parse($b->tanggal_mulai);
                        $selesai = \Carbon\Carbon::parse($b->tanggal_selesai);
                        $hari = $mulai->diffInDays($selesai) + 1;
                    @endphp

                    <tr>
                        <td data-label="Pemohon">
                            <strong>{{ optional($b->user)->name ?? 'User dihapus' }}</strong>
                            <span class="sub">{{ optional($b->user)->email }}</span>
                        </td>

                        <td data-label="Alat">
                            <ul class="item-list">
                                @foreach ($b->detail as $d)
                                    <li>
                                        <strong>{{ optional($d->alat)->nama_alat ?? 'Alat dihapus' }} × {{ $d->jumlah }}</strong>
                                        <span class="sub">
                                            {{ optional(optional($d->alat)->kategori)->nama_kategori ?? '-' }}
                                            · stok {{ optional($d->alat)->jumlah ?? 0 }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        <td data-label="Tanggal">
                            {{ $mulai->translatedFormat('d M Y') }} – {{ $selesai->translatedFormat('d M Y') }}
                            <span class="sub">{{ $hari }} hari</span>
                        </td>

                        <td data-label="Status">
                            <span class="stamp stamp-{{ $b->status }}">
                                {{ ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'completed' => 'Selesai'][$b->status] ?? $b->status }}
                            </span>
                            @if ($b->catatan)
                                <span class="sub">Catatan: {{ $b->catatan }}</span>
                            @endif
                            @if ($b->pengembalian)
                                <span class="sub">
                                    Kembali {{ $b->pengembalian->tanggal_kembali->translatedFormat('d M Y') }}
                                    ({{ $b->pengembalian->status }})
                                    @if ($b->pengembalian->denda > 0)
                                        · denda Rp {{ number_format($b->pengembalian->denda, 0, ',', '.') }}
                                    @endif
                                </span>
                            @endif
                        </td>

                        <td data-label="Aksi">

                            @if ($b->status === 'pending')

                                <div class="actions">
                                    <form action="{{ route('petugas.booking.setujui', $b->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-act btn-ok">Setujui</button>
                                    </form>

                                    <details class="reject">
                                        <summary class="btn-act btn-no">Tolak</summary>
                                        <form action="{{ route('petugas.booking.tolak', $b->id) }}" method="POST" class="reject-form">
                                            @csrf
                                            @method('PATCH')
                                            <label for="catatan-{{ $b->id }}">Alasan penolakan (opsional)</label>
                                            <textarea id="catatan-{{ $b->id }}" name="catatan" rows="2" maxlength="255"
                                                      placeholder="Contoh: alat sedang dipakai kegiatan lain"></textarea>
                                            <button type="submit" class="btn-act btn-no solid">Kirim penolakan</button>
                                        </form>
                                    </details>
                                </div>

                            @elseif ($b->status === 'approved')

                                <details class="reject">
                                    <summary class="btn-act">Catat pengembalian</summary>
                                    <form action="{{ route('petugas.booking.kembali', $b->id) }}" method="POST" class="reject-form">
                                        @csrf
                                        @method('PATCH')

                                        <label for="tgl-{{ $b->id }}">Tanggal kembali</label>
                                        <input type="date" id="tgl-{{ $b->id }}" name="tanggal_kembali" value="{{ date('Y-m-d') }}" required>

                                        <label for="denda-{{ $b->id }}">Denda (Rp)</label>
                                        <input type="number" id="denda-{{ $b->id }}" name="denda" value="0" min="0" step="1000">

                                        <label for="ket-{{ $b->id }}">Keterangan (opsional)</label>
                                        <textarea id="ket-{{ $b->id }}" name="keterangan" rows="2" maxlength="255"
                                                  placeholder="Contoh: kondisi alat baik"></textarea>

                                        <button type="submit" class="btn-act btn-ok">Simpan pengembalian</button>
                                    </form>
                                </details>

                            @else
                                <span class="sub">—</span>
                            @endif

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="empty-row">
                            <strong>Tidak ada pengajuan</strong>
                            Belum ada pengajuan dengan status ini.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    <div class="pager">
        @if ($bookings->previousPageUrl())
            <a href="{{ $bookings->previousPageUrl() }}" class="chip">← Sebelumnya</a>
        @endif
        @if ($bookings->nextPageUrl())
            <a href="{{ $bookings->nextPageUrl() }}" class="chip">Berikutnya →</a>
        @endif
    </div>

</main>

@endsection