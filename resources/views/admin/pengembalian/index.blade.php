@extends('layouts.master')

@section('title', 'RODA - Data Pengembalian')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/admin-pengembalian.css') }}">
@endpush
<style>
    /* public/css/admin-pengembalian.css  —  khusus admin/pengembalian/index.blade.php */

:root { color-scheme: light; --bg:#EFE9DC; --ink:#1F1D1A; --muted:#6B645A; --amber:#E4A233; --red:#B3371F; --card:#F7F2E7; --ok:#2F7D4F; }

body { background: var(--bg); color: var(--ink); font-family: 'Work Sans', system-ui, sans-serif; line-height: 1.6; }

.pengembalian { max-width: 1200px; margin: 0 auto; padding: 50px clamp(16px, 4vw, 40px) 90px; }
.pengembalian h1 { font-family: 'Oswald', 'Arial Narrow', sans-serif; margin: 0; }
.pengembalian :focus-visible { outline: 3px solid var(--amber); outline-offset: 3px; }

.eyebrow-plate { color: var(--red); font: 600 15px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; margin: 0 0 6px; }
.page-title { font-size: clamp(36px, 5vw, 56px); font-weight: 700; line-height: 1.05; margin-bottom: 12px; }
.page-sub { color: var(--muted); margin: 0 0 30px; max-width: 60ch; }

/* ---------- RINGKASAN ---------- */
.summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 24px; margin-bottom: 36px; }
.sum-card { background: var(--card); border: 2px solid var(--ink); box-shadow: 6px 6px 0 var(--ink); padding: 16px 18px; }
.sum-card b { display: block; font: 600 34px/1.15 'Oswald', sans-serif; }
.sum-card span { color: var(--muted); font-size: 14px; }
.sum-card.warn { box-shadow: 6px 6px 0 var(--red); }
.sum-card.warn b { color: var(--red); }

/* ---------- FILTER ---------- */
.toolbar { display: flex; flex-wrap: wrap; gap: 16px 24px; justify-content: space-between; align-items: center; margin-bottom: 28px; }
.chip-row, .pager { display: flex; flex-wrap: wrap; gap: 10px; }
.pager { margin-top: 28px; }
.chip { border: 2px solid var(--ink); background: transparent; color: var(--ink); padding: 8px 18px; font: 500 15px 'Work Sans', sans-serif; text-decoration: none; }
.chip.active { background: var(--ink); color: var(--bg); box-shadow: 4px 4px 0 var(--amber); }

.search-box { display: flex; flex: 1 1 300px; max-width: 420px; border: 2px solid var(--ink); background: var(--card); }
.search-box input { flex: 1; min-width: 0; border: 0; background: transparent; color: var(--ink); padding: 11px 14px; font: 500 15px 'Work Sans', sans-serif; }
.search-box input:focus { outline: none; }
.search-box:focus-within { outline: 3px solid var(--amber); outline-offset: 2px; }
.search-box button { border: 0; background: var(--ink); color: var(--bg); padding: 11px 18px; font: 600 14px 'Work Sans', sans-serif; cursor: pointer; }

/* ---------- TABEL ---------- */
.table-wrap { background: var(--card); border: 2px solid var(--ink); box-shadow: 8px 8px 0 var(--ink); overflow-x: auto; }
.data-table { width: 100%; border-collapse: collapse; min-width: 860px; }
.data-table th { text-align: left; background: var(--ink); color: #F7F2E7; padding: 12px 16px; font: 600 14px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; }
.data-table td { padding: 16px; border-bottom: 2px dashed rgba(31, 29, 26, .35); vertical-align: top; }
.data-table tr:last-child td { border-bottom: 0; }
.data-table strong { display: block; }
.sub { display: block; color: var(--muted); font-size: 13px; margin-top: 2px; }
.late { color: var(--red); }
.item-list { list-style: none; margin: 0; padding: 0; display: grid; gap: 4px; }
.item-list b { color: var(--red); }

.stamp { display: inline-block; padding: 3px 12px; border: 2px solid currentColor; font: 700 14px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; }
.stamp-ok { color: var(--ok); }
.stamp-late { color: var(--red); background: #F8E3DC; }

.empty-row { text-align: center; padding: 44px 16px !important; }
.empty-row strong { font: 600 24px 'Oswald', sans-serif; }

/* ---------- HP: tabel jadi kartu ---------- */
@media (max-width: 760px) {
    .data-table { min-width: 0; }
    .data-table thead { display: none; }
    .data-table, .data-table tbody, .data-table tr, .data-table td { display: block; width: 100%; }
    .data-table tr { border-bottom: 2px solid var(--ink); padding: 8px 0; }
    .data-table td { border: 0; padding: 8px 16px; }
    .data-table td::before { content: attr(data-label); display: block; color: var(--muted); font-size: 12px; text-transform: uppercase; letter-spacing: .1em; }
}
</style>

@section('content')

<main class="pengembalian">

    <p class="eyebrow-plate">PANEL ADMIN · PEMINJAMAN ALAT</p>
    <h1 class="page-title">Data pengembalian</h1>
    <p class="page-sub">Daftar alat yang sudah kembali setelah dipinjam, lengkap dengan status ketepatan waktu dan denda.</p>

    {{-- RINGKASAN --}}
    <div class="summary">
        <div class="sum-card">
            <b>{{ $ringkasan['total'] }}</b>
            <span>total pengembalian</span>
        </div>
        <div class="sum-card">
            <b>{{ $ringkasan['tepat_waktu'] }}</b>
            <span>tepat waktu</span>
        </div>
        <div class="sum-card warn">
            <b>{{ $ringkasan['terlambat'] }}</b>
            <span>terlambat</span>
        </div>
        <div class="sum-card">
            <b>Rp {{ number_format($ringkasan['denda'], 0, ',', '.') }}</b>
            <span>total denda</span>
        </div>
    </div>

    {{-- FILTER + CARI --}}
    <div class="toolbar">
        <div class="chip-row" role="group" aria-label="Filter status">
            @foreach (['semua' => 'Semua', 'tepat_waktu' => 'Tepat waktu', 'terlambat' => 'Terlambat'] as $key => $label)
                <a href="{{ route('admin.pengembalian.index', array_filter(['status' => $key, 'q' => $q])) }}"
                   class="chip {{ $filter === $key ? 'active' : '' }}">{{ $label }}</a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('admin.pengembalian.index') }}" class="search-box">
            <input type="hidden" name="status" value="{{ $filter }}">
            <input type="search" name="q" value="{{ $q }}" placeholder="Cari nama peminjam atau alat…" aria-label="Cari">
            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Alat</th>
                    <th>Dipinjam</th>
                    <th>Dikembalikan</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($pengembalian as $p)

                    @php
                        $b = $p->booking;
                        $terlambat = $p->status === 'terlambat';
                        $telatHari = ($b && $terlambat) ? (int) $b->tanggal_selesai->diffInDays($p->tanggal_kembali) : 0;
                    @endphp

                    <tr>
                        <td data-label="Peminjam">
                            <strong>{{ optional(optional($b)->user)->name ?? 'User dihapus' }}</strong>
                            <span class="sub">Pengajuan #{{ optional($b)->id }}</span>
                        </td>

                        <td data-label="Alat">
                            <ul class="item-list">
                                @foreach (optional($b)->detail ?? [] as $d)
                                    <li>{{ optional($d->alat)->nama_alat ?? 'Alat dihapus' }} <b>× {{ $d->jumlah }}</b></li>
                                @endforeach
                            </ul>
                        </td>

                        <td data-label="Dipinjam">
                            @if ($b)
                                {{ $b->tanggal_mulai->translatedFormat('d M Y') }} –<br>
                                {{ $b->tanggal_selesai->translatedFormat('d M Y') }}
                            @endif
                        </td>

                        <td data-label="Dikembalikan">
                            <strong>{{ $p->tanggal_kembali->translatedFormat('d M Y') }}</strong>
                            @if ($telatHari > 0)
                                <span class="sub late">telat {{ $telatHari }} hari</span>
                            @endif
                            @if ($p->keterangan && $p->keterangan !== '-')
                                <span class="sub">{{ $p->keterangan }}</span>
                            @endif
                        </td>

                        <td data-label="Status">
                            <span class="stamp {{ $terlambat ? 'stamp-late' : 'stamp-ok' }}">
                                {{ $terlambat ? 'Terlambat' : 'Tepat waktu' }}
                            </span>
                        </td>

                        <td data-label="Denda">
                            @if ($p->denda > 0)
                                <strong class="late">Rp {{ number_format($p->denda, 0, ',', '.') }}</strong>
                            @else
                                <span class="sub">—</span>
                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="empty-row">
                            <strong>Belum ada data pengembalian</strong>
                            Data muncul setelah admin mencatat pengembalian dari halaman verifikasi peminjaman.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    <div class="pager">
        @if ($pengembalian->previousPageUrl())
            <a href="{{ $pengembalian->previousPageUrl() }}" class="chip">← Sebelumnya</a>
        @endif
        @if ($pengembalian->nextPageUrl())
            <a href="{{ $pengembalian->nextPageUrl() }}" class="chip">Berikutnya →</a>
        @endif
    </div>

</main>

@endsection