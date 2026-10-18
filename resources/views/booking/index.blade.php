@extends('layouts.app')

@section('title', 'RODA - Riwayat Peminjaman')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/booking-index.css') }}">
@endpush

<style>
    /* public/css/booking-index.css  —  khusus booking/index.blade.php */

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

.riwayat { max-width: 1000px; margin: 0 auto; padding: 50px clamp(16px, 4vw, 40px) 90px; }
.riwayat h1, .riwayat h2 { font-family: 'Oswald', 'Arial Narrow', sans-serif; margin: 0; }
.riwayat :focus-visible { outline: 3px solid var(--amber); outline-offset: 3px; }

.eyebrow-plate { color: var(--red); font: 600 15px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; margin: 0 0 6px; }
.riwayat-title { font-size: clamp(36px, 5vw, 56px); font-weight: 700; line-height: 1.05; margin-bottom: 12px; }
.riwayat-sub { color: var(--muted); margin: 0 0 28px; }

/* ---------- ALERT ---------- */
.alert { padding: 14px 16px; margin-bottom: 24px; border: 2px solid var(--ink); }
.alert-success { background: #DDEBDD; border-color: var(--ok); color: #1E5535; font-weight: 500; }

/* ---------- FILTER ---------- */
.chip-row { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 34px; }
.chip {
    border: 2px solid var(--ink); background: transparent; color: var(--ink);
    padding: 8px 18px; font: 500 15px 'Work Sans', sans-serif; cursor: pointer;
}
.chip.active { background: var(--ink); color: var(--bg); box-shadow: 4px 4px 0 var(--amber); }

/* ---------- TIKET ---------- */
.ticket-list { display: grid; gap: 30px; }
.ticket {
    display: grid; grid-template-columns: 150px 1fr auto; background: var(--card);
    border: 2px solid var(--ink); box-shadow: 8px 8px 0 var(--ink);
}
.ticket[hidden] { display: none; }

.ticket-thumb {
    position: relative; min-height: 150px; display: grid; place-items: center; font-size: 46px;
    border-right: 2px dashed var(--ink); background: radial-gradient(circle, #EDC77C 0, #F1E3C6 75%);
}
.ticket-thumb img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; padding: 10px; mix-blend-mode: multiply; display: block; }

.ticket-main { padding: 20px 22px; min-width: 0; }
.ticket-main h2 { font-size: 26px; font-weight: 600; }
.ticket-cat { color: var(--muted); font-size: 14px; margin: 0 0 14px; }

.ticket-dates { display: flex; flex-wrap: wrap; gap: 8px 34px; margin: 0 0 14px; }
.ticket-dates div { display: block; }
.ticket-dates dt { color: var(--muted); font-size: 13px; }
.ticket-dates dd { margin: 0; font: 600 20px 'Oswald', sans-serif; }

.ticket-msg { font-size: 14px; color: var(--muted); margin: 0; }
.ticket-msg b { color: var(--ink); }

.ticket-status {
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px;
    padding: 20px 26px; border-left: 2px dashed var(--ink);
}
.ticket-id { font-size: 12px; color: var(--muted); text-align: center; }

/* ---------- CAP STATUS ---------- */
.stamp {
    display: inline-block; padding: 8px 18px; border: 3px solid currentColor;
    font: 700 20px 'Oswald', sans-serif; letter-spacing: .14em; text-transform: uppercase;
    transform: rotate(-5deg); background: var(--card);
}
.stamp-pending   { color: #9A6A0B; border-color: var(--amber); background: #FBEBC8; }
.stamp-disetujui { color: var(--ok); }
.stamp-ditolak   { color: var(--red); }
.stamp-selesai   { color: var(--muted); }

/* ---------- KOSONG ---------- */
.empty { border: 2px dashed var(--ink); padding: 44px 24px; text-align: center; }
.empty[hidden] { display: none; }
.empty strong { display: block; font: 600 26px 'Oswald', sans-serif; margin-bottom: 4px; }
.btn-primary {
    display: inline-block; margin-top: 20px; background: var(--amber); color: var(--ink); border: 2px solid var(--ink);
    padding: 12px 28px; font: 600 17px 'Oswald', sans-serif; letter-spacing: .03em; text-decoration: none;
    box-shadow: 6px 6px 0 var(--ink); transition: transform .12s, box-shadow .12s;
}
.btn-primary:hover { transform: translate(3px, 3px); box-shadow: 3px 3px 0 var(--ink); }

/* ---------- RESPONSIVE ---------- */
@media (max-width: 720px) {
    .ticket { grid-template-columns: 1fr; }
    .ticket-thumb { min-height: 170px; border-right: 0; border-bottom: 2px dashed var(--ink); }
    .ticket-status { flex-direction: row; justify-content: space-between; border-left: 0; border-top: 2px dashed var(--ink); padding: 16px 22px; }
}
@media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
</style>

@section('content')

@php
    $statusMap = [
        'pending'   => ['key' => 'pending',   'label' => 'Menunggu',  'pesan' => 'Pengajuan sedang menunggu persetujuan admin.'],
        'approved'  => ['key' => 'approved',  'label' => 'Disetujui', 'pesan' => 'Pengajuan disetujui. Ambil alat sesuai tanggal mulai.'],
        'rejected'  => ['key' => 'rejected',  'label' => 'Ditolak',   'pesan' => 'Pengajuan ditolak oleh admin.'],
        'completed' => ['key' => 'completed', 'label' => 'Selesai',   'pesan' => 'Alat sudah dikembalikan. Peminjaman selesai.'],
    ];

    $resolve = fn ($s) => $statusMap[strtolower($s ?? '')]
        ?? ['key' => 'pending', 'label' => ucfirst($s ?? 'Menunggu'), 'pesan' => ''];

    $hitung = fn ($k) => $penyewaan->where('status', $k)->count();
@endphp

<main class="riwayat">

    <p class="eyebrow-plate">PEMINJAMAN ALAT · CIMAHI &amp; SEKITARNYA</p>
    <h1 class="riwayat-title">Riwayat peminjaman</h1>
    <p class="riwayat-sub">Pantau status pengajuan Anda: menunggu, disetujui, atau ditolak.</p>

    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="chip-row" id="filters" role="group" aria-label="Filter status">
        <button type="button" class="chip active" data-filter="semua">Semua ({{ $penyewaan->count() }})</button>
        <button type="button" class="chip" data-filter="pending">Menunggu ({{ $hitung('pending') }})</button>
        <button type="button" class="chip" data-filter="approved">Disetujui ({{ $hitung('approved') }})</button>
        <button type="button" class="chip" data-filter="rejected">Ditolak ({{ $hitung('rejected') }})</button>
        <button type="button" class="chip" data-filter="completed">Selesai ({{ $hitung('completed') }})</button>
    </div>

    <div class="ticket-list" id="list">

        @forelse ($penyewaan as $item)

            @php
                $st = $resolve($item->status);
                $mulai = \Carbon\Carbon::parse($item->tanggal_mulai);
                $selesai = \Carbon\Carbon::parse($item->tanggal_selesai);
                $hari = $mulai->diffInDays($selesai) + 1;
                $pertama = optional($item->detail->first())->alat;
            @endphp

            <article class="ticket" data-status="{{ $st['key'] }}">

                <div class="ticket-thumb">
                    @if (optional($pertama)->foto)
                        <img src="{{ asset('storage/' . $pertama->foto) }}" alt="{{ $pertama->nama_alat }}">
                    @else
                        <span aria-hidden="true">🧰</span>
                    @endif
                </div>

                <div class="ticket-main">
                    <h2>Pengajuan #{{ $item->id }}</h2>

                    <ul class="ticket-items">
                        @foreach ($item->detail as $d)
                            <li>
                                <b>{{ optional($d->alat)->nama_alat ?? 'Alat dihapus' }}</b>
                                <span>× {{ $d->jumlah }}</span>
                                <em>{{ optional(optional($d->alat)->kategori)->nama_kategori }}</em>
                            </li>
                        @endforeach
                    </ul>

                    <dl class="ticket-dates">
                        <div><dt>Mulai</dt><dd>{{ $mulai->translatedFormat('d M Y') }}</dd></div>
                        <div><dt>Selesai</dt><dd>{{ $selesai->translatedFormat('d M Y') }}</dd></div>
                        <div><dt>Lama</dt><dd>{{ $hari }} hari</dd></div>
                    </dl>

                    <p class="ticket-msg">
                        {{ $st['pesan'] }}

                        @if (!empty($item->catatan))
                            <br><b>Catatan admin:</b> {{ $item->catatan }}
                        @endif

                        @if ($item->pengembalian)
                            <br><b>Dikembalikan:</b> {{ $item->pengembalian->tanggal_kembali->translatedFormat('d M Y') }}
                            ({{ $item->pengembalian->status }})
                            @if ($item->pengembalian->denda > 0)
                                · <b>Denda:</b> Rp {{ number_format($item->pengembalian->denda, 0, ',', '.') }}
                            @endif
                        @endif
                    </p>
                </div>

                <div class="ticket-status">
                    <span class="stamp stamp-{{ $st['key'] }}">{{ $st['label'] }}</span>
                    <span class="ticket-id">Diajukan {{ optional($item->created_at)->translatedFormat('d M Y') }}</span>
                </div>

            </article>

        @empty

            <div class="empty">
                <strong>Belum ada pengajuan</strong>
                Pilih alat yang ingin dipinjam, lalu ajukan peminjaman.
                <br>
                <a href="{{ route('alat.index') }}" class="btn-primary">Lihat alat</a>
            </div>

        @endforelse

        <div class="empty" id="emptyFilter" hidden>
            <strong>Tidak ada pengajuan</strong>
            Belum ada pengajuan dengan status ini.
        </div>

    </div>

</main>

<script>
    const chips = document.querySelectorAll('#filters .chip');
    const tickets = document.querySelectorAll('.ticket');
    const emptyFilter = document.getElementById('emptyFilter');

    chips.forEach(chip => chip.addEventListener('click', () => {
        chips.forEach(c => c.classList.toggle('active', c === chip));
        const f = chip.dataset.filter;
        let shown = 0;
        tickets.forEach(t => {
            const show = f === 'semua' || t.dataset.status === f;
            t.hidden = !show;
            if (show) shown++;
        });
        emptyFilter.hidden = shown !== 0 || tickets.length === 0;
    }));
</script>

@endsection