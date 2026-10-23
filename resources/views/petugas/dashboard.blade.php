@extends('layouts.petugas')

@section('title', 'RODA - Dashboard Petugas')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/petugas-dashboard.css') }}">
@endpush

<style>
    /* public/css/petugas-dashboard.css  —  khusus petugas/dashboard.blade.php */

:root { color-scheme: light; --bg:#EFE9DC; --ink:#1F1D1A; --muted:#6B645A; --amber:#E4A233; --red:#B3371F; --card:#F7F2E7; --ok:#2F7D4F; }

body { background: var(--bg); color: var(--ink); font-family: 'Work Sans', system-ui, sans-serif; line-height: 1.6; }

.petugas-dash { max-width: 1200px; margin: 0 auto; padding: 30px clamp(16px, 4vw, 40px) 90px; }
.petugas-dash h1, .petugas-dash h2, .petugas-dash h3 { font-family: 'Oswald', 'Arial Narrow', sans-serif; margin: 0; }
.petugas-dash :focus-visible { outline: 3px solid var(--amber); outline-offset: 3px; }

/* ---------- MENU ATAS ---------- */
.petugas-menu { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 36px; padding-bottom: 18px; border-bottom: 2px solid var(--ink); }
.petugas-menu a { border: 2px solid var(--ink); color: var(--ink); padding: 7px 18px; font: 500 15px 'Work Sans', sans-serif; text-decoration: none; }
.petugas-menu a:hover { box-shadow: 3px 3px 0 var(--amber); }
.petugas-menu a.active { background: var(--ink); color: var(--bg); box-shadow: 4px 4px 0 var(--amber); }

.eyebrow-plate { color: var(--red); font: 600 15px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; margin: 0 0 6px; }
.page-title { font-size: clamp(36px, 5vw, 56px); font-weight: 700; line-height: 1.05; margin-bottom: 10px; }
.page-sub { color: var(--muted); margin: 0 0 32px; }
.section-title { font: 600 28px 'Oswald', sans-serif; margin: 44px 0 18px; }

/* ---------- STATISTIK ---------- */
.stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 26px; }
.stat-card {
    display: block; background: var(--card); border: 2px solid var(--ink); box-shadow: 7px 7px 0 var(--ink);
    padding: 18px 20px; color: var(--ink); text-decoration: none; transition: transform .12s, box-shadow .12s;
}
.stat-card:hover { transform: translate(3px, 3px); box-shadow: 4px 4px 0 var(--ink); }
.stat-card b { display: block; font: 600 44px/1.1 'Oswald', sans-serif; }
.stat-card span { color: var(--muted); font-size: 15px; }
.stat-card.attn { box-shadow: 7px 7px 0 var(--amber); background: #FBEBC8; }
.stat-card.attn:hover { box-shadow: 4px 4px 0 var(--amber); }
.stat-card.danger { box-shadow: 7px 7px 0 var(--red); }
.stat-card.danger b { color: var(--red); }

/* ---------- KARTU MENU ---------- */
.menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 30px; }
.menu-card {
    display: flex; flex-direction: column; gap: 8px; background: var(--card); border: 2px solid var(--ink);
    box-shadow: 8px 8px 0 var(--ink); padding: 22px; color: var(--ink); text-decoration: none;
    transition: transform .12s, box-shadow .12s;
}
.menu-card:nth-child(odd) { transform: rotate(-.5deg); }
.menu-card:nth-child(even) { transform: rotate(.4deg); }
.menu-card:hover { transform: translate(3px, 3px); box-shadow: 4px 4px 0 var(--ink); }
.menu-icon { width: 54px; height: 54px; display: grid; place-items: center; font-size: 28px; background: radial-gradient(circle, #EDC77C 0, #F1E3C6 80%); border: 2px solid var(--ink); }
.menu-card h3 { font-size: 24px; font-weight: 600; }
.menu-card p { color: var(--muted); font-size: 15px; margin: 0; }
.menu-go { margin-top: auto; padding-top: 10px; font: 600 16px 'Oswald', sans-serif; letter-spacing: .05em; color: var(--red); }

/* ---------- PANEL DAFTAR ---------- */
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 36px; }
.two-col .section-title { margin-top: 44px; }
.panel { background: var(--card); border: 2px solid var(--ink); box-shadow: 7px 7px 0 var(--ink); }
.row { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 14px 18px; border-bottom: 2px dashed rgba(31, 29, 26, .35); }
.row:last-child { border-bottom: 0; }
.row-main { min-width: 0; }
.row-main strong { display: block; }
.sub { display: block; color: var(--muted); font-size: 13px; }
.sub.late { color: var(--red); font-weight: 600; }
.panel-empty { margin: 0; padding: 26px 18px; text-align: center; color: var(--muted); }

.btn-mini { flex-shrink: 0; background: var(--ink); color: var(--bg); border: 2px solid var(--ink); padding: 6px 14px; font: 600 14px 'Work Sans', sans-serif; text-decoration: none; box-shadow: 3px 3px 0 var(--amber); }
.btn-mini:hover { background: var(--amber); color: var(--ink); }

.stamp { display: inline-block; flex-shrink: 0; padding: 3px 12px; border: 2px solid currentColor; font: 700 14px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; }
.stamp-late { color: var(--red); background: #F8E3DC; }
.stamp-warn { color: #9A6A0B; background: #FBEBC8; border-color: var(--amber); }

@media (max-width: 860px) { .two-col { grid-template-columns: 1fr; gap: 0; } }
@media (max-width: 480px) { .menu-card { transform: none !important; } }
@media (prefers-reduced-motion: reduce) { * { transition: none !important; } }

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

@php
    $ringkasAlat = fn ($b) => $b->detail
        ->map(fn ($d) => (optional($d->alat)->nama_alat ?? 'Alat dihapus') . ' × ' . $d->jumlah)
        ->implode(', ');
@endphp

<main class="petugas-dash">


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
    <h1 class="page-title">Halo, {{ auth()->user()->name }}</h1>
    <p class="page-sub">{{ now()->translatedFormat('l, d F Y') }} · Ini ringkasan yang perlu Anda tangani hari ini.</p>

    {{-- STATISTIK --}}
    <section class="stat-grid" aria-label="Ringkasan">

        <a href="{{ route('petugas.booking.index', ['status' => 'pending']) }}"
           class="stat-card {{ $statistik['menunggu'] > 0 ? 'attn' : '' }}">
            <b>{{ $statistik['menunggu'] }}</b>
            <span>menunggu verifikasi</span>
        </a>

        <a href="{{ route('petugas.pengembalian.index') }}" class="stat-card">
            <b>{{ $statistik['dipinjam'] }}</b>
            <span>sedang dipinjam</span>
        </a>

        <a href="{{ route('petugas.pengembalian.index') }}"
           class="stat-card {{ $statistik['lewat'] > 0 ? 'danger' : '' }}">
            <b>{{ $statistik['lewat'] }}</b>
            <span>lewat jatuh tempo</span>
        </a>

        <a href="{{ route('petugas.laporan.index', ['jenis' => 'pengembalian']) }}" class="stat-card">
            <b>{{ $statistik['kembali'] }}</b>
            <span>dikembalikan bulan ini</span>
        </a>

    </section>

    {{-- MENU FITUR --}}
    <h2 class="section-title">Menu petugas</h2>

    <section class="menu-grid">

        <a href="{{ route('petugas.booking.index') }}" class="menu-card">
            <span class="menu-icon" aria-hidden="true">✅</span>
            <h3>Verifikasi peminjaman</h3>
            <p>Setujui atau tolak pengajuan peminjam, dan catat alat yang dikembalikan.</p>
            <span class="menu-go">Buka →</span>
        </a>

        <a href="{{ route('petugas.pengembalian.index') }}" class="menu-card">
            <span class="menu-icon" aria-hidden="true">📦</span>
            <h3>Pantau pengembalian</h3>
            <p>Lihat alat yang masih dipinjam, yang lewat tempo, dan riwayat pengembalian beserta denda.</p>
            <span class="menu-go">Buka →</span>
        </a>

        <a href="{{ route('petugas.laporan.index') }}" class="menu-card">
            <span class="menu-icon" aria-hidden="true">🖨️</span>
            <h3>Laporan</h3>
            <p>Susun laporan peminjaman atau pengembalian per periode, lalu cetak atau simpan PDF.</p>
            <span class="menu-go">Buka →</span>
        </a>

    </section>

    {{-- PERLU TINDAKAN --}}
    <div class="two-col">

        <section>
            <h2 class="section-title">Perlu diverifikasi</h2>

            <div class="panel">
                @forelse ($perluDiverifikasi as $b)
                    <div class="row">
                        <div class="row-main">
                            <strong>{{ optional($b->user)->name ?? 'User dihapus' }}</strong>
                            <span class="sub">{{ $ringkasAlat($b) }}</span>
                            <span class="sub">
                                {{ $b->tanggal_mulai->translatedFormat('d M') }} – {{ $b->tanggal_selesai->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        <a href="{{ route('petugas.booking.index', ['status' => 'pending']) }}" class="btn-mini">Tinjau</a>
                    </div>
                @empty
                    <p class="panel-empty">Tidak ada pengajuan yang menunggu. 🎉</p>
                @endforelse
            </div>
        </section>

        <section>
            <h2 class="section-title">Lewat jatuh tempo</h2>

            <div class="panel">
                @forelse ($lewatTempo as $b)
                    @php $hari = (int) $b->tanggal_selesai->diffInDays(today()); @endphp
                    <div class="row">
                        <div class="row-main">
                            <strong>{{ optional($b->user)->name ?? 'User dihapus' }}</strong>
                            <span class="sub">{{ $ringkasAlat($b) }}</span>
                            <span class="sub late">Seharusnya kembali {{ $b->tanggal_selesai->translatedFormat('d M Y') }} · telat {{ $hari }} hari</span>
                        </div>
                        <a href="{{ route('petugas.booking.index', ['status' => 'approved']) }}" class="btn-mini">Catat</a>
                    </div>
                @empty
                    <p class="panel-empty">Tidak ada alat yang terlambat dikembalikan.</p>
                @endforelse
            </div>
        </section>

    </div>

    {{-- STOK MENIPIS --}}
    @if ($stokMenipis->isNotEmpty())
        <h2 class="section-title">Stok menipis</h2>

        <div class="panel">
            @foreach ($stokMenipis as $alat)
                <div class="row">
                    <div class="row-main">
                        <strong>{{ $alat->nama_alat }}</strong>
                    </div>
                    <span class="stamp {{ $alat->jumlah < 1 ? 'stamp-late' : 'stamp-warn' }}">
                        {{ $alat->jumlah < 1 ? 'Habis' : 'Sisa ' . $alat->jumlah }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif

</main>

@endsection