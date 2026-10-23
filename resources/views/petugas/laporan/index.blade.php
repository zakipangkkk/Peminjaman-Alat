@extends('layouts.petugas')

@section('title', 'RODA - Laporan')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/petugas-laporan.css') }}">
@endpush

<style>
    /* public/css/petugas-laporan.css  —  khusus petugas/laporan/index.blade.php (berdiri sendiri) */

:root {
    color-scheme: light;
    --bg: #EFE9DC;
    --ink: #1F1D1A;
    --muted: #6B645A;
    --amber: #E4A233;
    --red: #B3371F;
    --card: #F7F2E7;
    --ok: #2F7D4F;
}

body { background: var(--bg); color: var(--ink); font-family: 'Work Sans', system-ui, sans-serif; line-height: 1.6; }

.laporan { max-width: 1200px; margin: 0 auto; padding: 30px clamp(16px, 4vw, 40px) 90px; }
.laporan h1 { font-family: 'Oswald', 'Arial Narrow', sans-serif; margin: 0; }
.laporan :focus-visible { outline: 3px solid var(--amber); outline-offset: 3px; }

/* ---------- MENU ATAS PETUGAS ---------- */
.petugas-menu { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 36px; padding-bottom: 18px; border-bottom: 2px solid var(--ink); }
.petugas-menu a { border: 2px solid var(--ink); color: var(--ink); padding: 7px 18px; font: 500 15px 'Work Sans', sans-serif; text-decoration: none; }
.petugas-menu a:hover { box-shadow: 3px 3px 0 var(--amber); }
.petugas-menu a.active { background: var(--ink); color: var(--bg); box-shadow: 4px 4px 0 var(--amber); }

/* ---------- JUDUL ---------- */
.eyebrow-plate { color: var(--red); font: 600 15px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; margin: 0 0 6px; }
.page-title { font-size: clamp(36px, 5vw, 56px); font-weight: 700; line-height: 1.05; margin-bottom: 12px; }
.page-sub { color: var(--muted); margin: 0 0 30px; max-width: 60ch; }

.alert-error { border: 2px solid var(--red); background: #F8E3DC; color: #7A2412; padding: 12px 16px; margin-bottom: 22px; }

/* ---------- FILTER ---------- */
.filter-form {
    display: flex; flex-wrap: wrap; align-items: flex-end; gap: 18px 22px; margin-bottom: 34px; padding: 22px;
    background: var(--card); border: 2px solid var(--ink); box-shadow: 8px 8px 0 var(--amber);
}
.filter-form .field { min-width: 170px; }
.filter-form .field[hidden] { display: none; }
.filter-form label { display: block; font: 600 15px 'Oswald', sans-serif; letter-spacing: .04em; margin-bottom: 6px; }
.filter-form select, .filter-form input[type="date"] {
    width: 100%; border: 2px solid var(--ink); background: var(--bg); color: var(--ink);
    padding: 10px 12px; font: 500 15px 'Work Sans', sans-serif; border-radius: 0;
}
.filter-actions { display: flex; flex-wrap: wrap; gap: 14px; margin-left: auto; }

.btn-solid, .btn-amber {
    display: inline-block; border: 2px solid var(--ink); padding: 10px 22px; cursor: pointer; text-decoration: none;
    font: 600 16px 'Oswald', sans-serif; letter-spacing: .04em; transition: transform .12s, box-shadow .12s;
}
.btn-solid { background: var(--ink); color: var(--bg); box-shadow: 5px 5px 0 var(--amber); }
.btn-amber { background: var(--amber); color: var(--ink); box-shadow: 5px 5px 0 var(--ink); }
.btn-solid:hover, .btn-amber:hover { transform: translate(3px, 3px); box-shadow: 2px 2px 0 var(--ink); }

/* ---------- RINGKASAN ---------- */
.summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 24px; margin-bottom: 34px; }
.sum-card { background: var(--card); border: 2px solid var(--ink); box-shadow: 6px 6px 0 var(--ink); padding: 16px 18px; }
.sum-card b { display: block; font: 600 32px/1.15 'Oswald', sans-serif; }
.sum-card span { color: var(--muted); font-size: 14px; }

/* ---------- TABEL ---------- */
.table-wrap { background: var(--card); border: 2px solid var(--ink); box-shadow: 8px 8px 0 var(--ink); overflow-x: auto; }
.data-table { width: 100%; border-collapse: collapse; min-width: 820px; }
.data-table th {
    text-align: left; background: var(--ink); color: #F7F2E7; padding: 12px 16px;
    font: 600 14px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase;
}
.data-table td { padding: 14px 16px; border-bottom: 2px dashed rgba(31, 29, 26, .35); vertical-align: top; }
.data-table tr:last-child td { border-bottom: 0; }
.empty-row { text-align: center; padding: 40px 16px !important; color: var(--muted); }

/* ---------- RESPONSIVE ---------- */
@media (max-width: 760px) {
    .filter-actions { margin-left: 0; width: 100%; }
    .data-table { min-width: 0; }
    .data-table thead { display: none; }
    .data-table, .data-table tbody, .data-table tr, .data-table td { display: block; width: 100%; }
    .data-table tr { border-bottom: 2px solid var(--ink); padding: 8px 0; }
    .data-table td { border: 0; padding: 6px 16px; }
    .data-table td::before { content: attr(data-label); display: block; color: var(--muted); font-size: 12px; text-transform: uppercase; letter-spacing: .1em; }
}
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

<main class="laporan">

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
    <h1 class="page-title">Laporan</h1>
    <p class="page-sub">Pilih jenis laporan dan periode, lalu cetak atau simpan sebagai PDF.</p>

    @if ($errors->any())
        <div class="alert-error" role="alert">
            @foreach ($errors->all() as $error) <div>{{ $error }}</div> @endforeach
        </div>
    @endif

    {{-- FILTER --}}
    <form method="GET" action="{{ route('petugas.laporan.index') }}" class="filter-form">

        <div class="field">
            <label for="jenis">Jenis laporan</label>
            <select id="jenis" name="jenis">
                <option value="peminjaman" @selected($jenis === 'peminjaman')>Peminjaman</option>
                <option value="pengembalian" @selected($jenis === 'pengembalian')>Pengembalian</option>
            </select>
        </div>

        <div class="field">
            <label for="dari">Dari tanggal</label>
            <input type="date" id="dari" name="dari" value="{{ $dari }}">
        </div>

        <div class="field">
            <label for="sampai">Sampai tanggal</label>
            <input type="date" id="sampai" name="sampai" value="{{ $sampai }}">
        </div>

        <div class="field" id="statusField">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">Semua</option>
                @foreach (['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'completed' => 'Selesai'] as $k => $v)
                    <option value="{{ $k }}" @selected($status === $k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-solid">Tampilkan</button>
            <a href="{{ route('petugas.laporan.cetak', request()->query()) }}" target="_blank" rel="noopener" class="btn-amber">Cetak laporan</a>
        </div>

    </form>

    {{-- RINGKASAN --}}
    <div class="summary">
        @foreach ($ringkasan as [$label, $nilai])
            <div class="sum-card">
                <b>{{ $nilai }}</b>
                <span>{{ $label }}</span>
            </div>
        @endforeach
    </div>

    <div class="table-wrap">
        @include('petugas.laporan._tabel')
    </div>

</main>

<script>
    const jenis = document.getElementById('jenis');
    const statusField = document.getElementById('statusField');
    const toggle = () => { statusField.hidden = jenis.value === 'pengembalian'; };
    jenis.addEventListener('change', toggle);
    toggle();
</script>

@endsection