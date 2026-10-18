@extends('layouts.app')

@section('title', 'RODA - Daftar Alat')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/alat-index.css') }}">
@endpush

<style>
    /* public/css/alat-index.css  —  khusus halaman alat/index.blade.php */

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

html { scroll-behavior: smooth; }
body { background: var(--bg); color: var(--ink); font-family: 'Work Sans', system-ui, sans-serif; line-height: 1.6; }

.dashboard { max-width: 1300px; margin: 0 auto; padding: 0 clamp(16px, 4vw, 40px); }
.dashboard h2, .dashboard h3 { font-family: 'Oswald', 'Arial Narrow', sans-serif; margin: 0; }
.dashboard :focus-visible { outline: 3px solid var(--amber); outline-offset: 3px; }

/* ---------- HEADER HALAMAN ---------- */
.categories { padding: 60px 0 90px; }

.eyebrow-plate {
    color: var(--red); font: 600 15px 'Oswald', sans-serif;
    letter-spacing: .12em; text-transform: uppercase; margin: 0 0 6px;
}
.section-title { font-size: clamp(36px, 5vw, 56px); font-weight: 700; line-height: 1.05; margin-bottom: 16px; }
.section-label { color: var(--muted); font-size: 15px; margin: 0 0 18px; }

/* ---------- KATEGORI ---------- */
.chip-row { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 22px; }
.chip {
    border: 2px solid var(--ink); background: transparent; color: var(--ink);
    padding: 8px 18px; font: 500 15px 'Work Sans', sans-serif; text-decoration: none;
    transition: transform .12s, box-shadow .12s;
}
.chip:hover { box-shadow: 3px 3px 0 var(--amber); transform: translate(-1px, -1px); }
.chip.active { background: var(--ink); color: var(--bg); box-shadow: 4px 4px 0 var(--amber); }

/* ---------- PENCARIAN ---------- */
.search-box {
    display: flex; max-width: 460px; margin-bottom: 38px;
    border: 2px solid var(--ink); background: var(--card);
}
.search-box input {
    flex: 1; min-width: 0; border: 0; background: transparent; color: var(--ink);
    padding: 12px 14px; font: 500 15px 'Work Sans', sans-serif;
}
.search-box input:focus { outline: none; }
.search-box:focus-within { outline: 3px solid var(--amber); outline-offset: 2px; }
.search-box button {
    border: 0; background: var(--ink); color: var(--bg); padding: 12px 18px;
    font: 600 14px 'Work Sans', sans-serif; cursor: pointer;
}

/* ---------- KARTU ALAT ---------- */
.tool-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 36px 28px; }

.tool-card {
    background: var(--card); border: 2px solid var(--ink); box-shadow: 8px 8px 0 var(--ink);
    display: flex; flex-direction: column;
}
.tool-card:nth-child(3n+1) { transform: rotate(-.6deg); }
.tool-card:nth-child(3n+2) { transform: rotate(.5deg); }

.tool-thumb {
    position: relative; height: 190px; display: grid; place-items: center; font-size: 52px;
    border-bottom: 2px solid var(--ink); background: radial-gradient(circle, #EDC77C 0, #F1E3C6 75%);
}
.tool-thumb img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; padding: 10px; mix-blend-mode: multiply; display: block; }
.tool-tag {
    position: absolute; left: 10px; bottom: -13px; background: #1F1D1A; color: #F7F2E7;
    font: 600 12px 'Oswald', sans-serif; letter-spacing: .14em; padding: 4px 10px; text-transform: uppercase;
}

.tool-body { padding: 26px 16px 16px; display: flex; flex-direction: column; gap: 4px; flex: 1; }
.tool-body h3 { font-size: 22px; font-weight: 600; }
.tool-cat { font-size: 14px; color: var(--muted); margin: 0; }

.tool-meta { display: flex; justify-content: space-between; align-items: center; gap: 8px; margin-top: auto; padding-top: 14px; }
.tool-stok { font-size: 14px; font-weight: 600; }
.tool-stok.ok { color: var(--ok); }
.tool-stok.out { color: var(--red); }

.btn-small {
    display: inline-block; background: var(--ink); color: var(--bg); border: 2px solid var(--ink);
    padding: 7px 16px; font: 600 14px 'Work Sans', sans-serif; text-decoration: none;
    box-shadow: 4px 4px 0 var(--amber); transition: transform .12s, box-shadow .12s;
}
.btn-small:hover { transform: translate(2px, 2px); box-shadow: 2px 2px 0 var(--amber); }
.btn-small.disabled { background: transparent; color: var(--muted); border-style: dashed; box-shadow: none; cursor: not-allowed; transform: none; }

/* ---------- KOSONG ---------- */
.tool-empty { grid-column: 1 / -1; border: 2px dashed var(--ink); padding: 40px; text-align: center; }
.tool-empty strong { display: block; font: 600 24px 'Oswald', sans-serif; }

/* ---------- RESPONSIVE ---------- */
@media (max-width: 560px) {
    .categories { padding-top: 40px; }
    .tool-card { transform: none !important; }
    .search-box { max-width: 100%; }
}
@media (prefers-reduced-motion: reduce) {
    html { scroll-behavior: auto; }
    * { transition: none !important; }
}

/* ---------- KERANJANG (tambahan) ---------- */
.alert { padding: 14px 16px; margin-bottom: 22px; border: 2px solid var(--ink); }
.alert-success { background: #DDEBDD; border-color: var(--ok); color: #1E5535; font-weight: 500; }
.alert-error { background: #F8E3DC; border-color: var(--red); color: #7A2412; }

.tool-actions { display: flex; align-items: center; gap: 10px; }
.tool-actions form { margin: 0; }
button.btn-small { cursor: pointer; }
.btn-small.ghost { background: transparent; color: var(--ink); box-shadow: none; }
.btn-small.ghost:hover { background: var(--amber); transform: none; box-shadow: none; }
.tool-meta { flex-wrap: wrap; }
</style>

@section('content')

<main class="dashboard">

    <section class="categories">

        <p class="eyebrow-plate">
            PEMINJAMAN ALAT · CIMAHI &amp; SEKITARNYA
        </p>

        <h2 class="section-title">Daftar alat</h2>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" role="alert">{{ session('error') }}</div>
        @endif

        <p class="section-label">
            Cari berdasarkan kategori
        </p>

        {{-- KATEGORI --}}
        <div class="chip-row">

            <a href="{{ route('alat.index') }}"
               class="chip {{ request('kategori') ? '' : 'active' }}">
                Semua
            </a>

            @foreach ($kategori as $item)
                <a href="{{ route('alat.index', ['kategori' => $item->nama_kategori]) }}"
                   class="chip {{ request('kategori') === $item->nama_kategori ? 'active' : '' }}">
                    {{ $item->nama_kategori }}
                </a>
            @endforeach

        </div>

        {{-- PENCARIAN --}}
        <form method="GET" action="{{ route('alat.index') }}" class="search-box">
            @if (request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif

            <input type="search" name="q" value="{{ request('q') }}"
                   placeholder="Cari nama alat…" aria-label="Cari alat">
            <button type="submit">Cari</button>
        </form>

        {{-- DAFTAR --}}
        <div class="tool-grid">

            @forelse ($alats as $alat)

                <article class="tool-card">

                    <div class="tool-thumb">
                        @if ($alat->foto)
                            <img src="{{ asset('storage/' . $alat->foto) }}"
                                 alt="{{ $alat->nama_alat }}">
                        @else
                            <span aria-hidden="true">🧰</span>
                        @endif

                        <span class="tool-tag">Alat siap</span>
                    </div>

                    <div class="tool-body">
                        <h3>{{ $alat->nama_alat }}</h3>

                        <p class="tool-cat">
                            {{ $alat->kategori->nama_kategori ?? '-' }}
                        </p>

                        <div class="tool-meta">
                            <span class="tool-stok ok">
                                {{ $alat->jumlah }} unit tersedia
                            </span>

                            <div class="tool-actions">
                                <form action="{{ route('keranjang.tambah', $alat->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-small ghost">+ Keranjang</button>
                                </form>

                                <a href="{{ route('alat.detail', $alat->id) }}"
                                   class="btn-small">
                                    Pinjam
                                </a>
                            </div>
                        </div>
                    </div>

                </article>

            @empty

                <div class="tool-empty">
                    <strong>Alat tidak ditemukan</strong>
                    Coba kata kunci lain atau pilih kategori Semua.
                </div>

            @endforelse

        </div>

    </section>

</main>

@endsection