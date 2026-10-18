@extends('layouts.app')

@section('title', 'RODA - Ajukan Peminjaman')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/booking-create.css') }}">
@endpush
<style>
    /* public/css/booking-create.css  —  khusus booking/create.blade.php */

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

.booking { max-width: 1100px; margin: 0 auto; padding: 40px clamp(16px, 4vw, 40px) 90px; }
.booking h1, .booking h2 { font-family: 'Oswald', 'Arial Narrow', sans-serif; margin: 0; }
.booking :focus-visible { outline: 3px solid var(--amber); outline-offset: 3px; }

.back-link { display: inline-block; color: var(--muted); text-decoration: none; font-weight: 500; margin-bottom: 28px; }
.back-link:hover { color: var(--ink); text-decoration: underline; }

.eyebrow-plate { color: var(--red); font: 600 15px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; margin: 0 0 6px; }
.booking-title { font-size: clamp(36px, 5vw, 56px); font-weight: 700; line-height: 1.05; margin-bottom: 36px; }

.booking-layout { display: grid; grid-template-columns: 340px 1fr; gap: 48px; align-items: start; }

/* ---------- RINGKASAN ALAT ---------- */
.tool-summary { background: var(--card); border: 2px solid var(--ink); box-shadow: 8px 8px 0 var(--ink); transform: rotate(-.6deg); }
.summary-thumb {
    position: relative; height: 220px; display: grid; place-items: center; font-size: 60px;
    border-bottom: 2px solid var(--ink); background: radial-gradient(circle, #EDC77C 0, #F1E3C6 75%);
}
.summary-thumb img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; padding: 12px; mix-blend-mode: multiply; display: block; }
.tool-tag {
    position: absolute; left: 10px; bottom: -13px; background: #1F1D1A; color: #F7F2E7;
    font: 600 12px 'Oswald', sans-serif; letter-spacing: .14em; padding: 4px 10px; text-transform: uppercase;
}
.summary-body { padding: 28px 18px 20px; }
.summary-body h2 { font-size: 26px; font-weight: 600; }
.summary-cat { color: var(--muted); font-size: 14px; margin: 2px 0 10px; }
.summary-stok { color: var(--ok); font-weight: 600; font-size: 14px; margin: 0; }

/* ---------- FORM ---------- */
.booking-form { background: var(--card); border: 2px solid var(--ink); box-shadow: 10px 10px 0 var(--amber); padding: clamp(20px, 4vw, 36px); }

.field { margin-bottom: 22px; }
.field label { display: block; font: 600 17px 'Oswald', sans-serif; letter-spacing: .03em; margin-bottom: 8px; }
.field input {
    width: 100%; border: 2px solid var(--ink); background: var(--bg); color: var(--ink);
    padding: 12px 14px; font: 500 16px 'Work Sans', sans-serif; border-radius: 0;
}
.field input:focus { outline: 3px solid var(--amber); outline-offset: 2px; }
.field input.invalid { border-color: var(--red); background: #F8E3DC; }

.duration { color: var(--muted); font-size: 15px; margin: 0; }

.road { border-top: 2px dashed var(--ink); opacity: .6; margin: 26px 0; }

.form-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 22px; }
.btn-primary {
    display: inline-block; background: var(--amber); color: var(--ink); border: 2px solid var(--ink);
    padding: 14px 30px; font: 600 18px 'Oswald', sans-serif; letter-spacing: .03em; cursor: pointer;
    box-shadow: 6px 6px 0 var(--ink); transition: transform .12s, box-shadow .12s;
}
.btn-primary:hover { transform: translate(3px, 3px); box-shadow: 3px 3px 0 var(--ink); }
.btn-ghost { color: var(--ink); font-weight: 600; text-decoration: underline; text-underline-offset: 4px; }

.form-note { color: var(--muted); font-size: 14px; margin: 20px 0 0; }

/* ---------- ALERT ---------- */
.alert { border: 2px solid var(--red); background: #F8E3DC; color: #7A2412; padding: 14px 16px; margin-bottom: 24px; }
.alert ul { margin: 6px 0 0; padding-left: 20px; }

/* ---------- RESPONSIVE ---------- */
@media (max-width: 820px) {
    .booking-layout { grid-template-columns: 1fr; gap: 40px; }
    .tool-summary { max-width: 380px; }
}
@media (max-width: 480px) {
    .tool-summary { transform: none; }
}
@media (prefers-reduced-motion: reduce) {
    * { transition: none !important; }
}
</style>

@section('content')

<main class="booking">

    <a href="{{ route('alat.index') }}" class="back-link">← Kembali ke daftar alat</a>

    <p class="eyebrow-plate">PEMINJAMAN ALAT · CIMAHI &amp; SEKITARNYA</p>
    <h1 class="booking-title">Ajukan peminjaman</h1>

    <div class="booking-layout">

        {{-- RINGKASAN ALAT --}}
        <aside class="tool-summary">

            <div class="summary-thumb">
                @if ($alat->foto)
                    <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}">
                @else
                    <span aria-hidden="true">🧰</span>
                @endif
                <span class="tool-tag">Alat siap</span>
            </div>

            <div class="summary-body">
                <h2>{{ $alat->nama_alat }}</h2>
                <p class="summary-cat">{{ $alat->kategori->nama_kategori ?? '-' }}</p>
                <p class="summary-stok">{{ $alat->jumlah }} unit tersedia</p>
            </div>

        </aside>

        {{-- FORM --}}
        <form action="{{ route('booking.store') }}" method="POST" class="booking-form" novalidate>
            @csrf

            <input type="hidden" name="alat_id" value="{{ $alat->id }}">

            @if (session('error'))
                <div class="alert alert-error" role="alert">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <strong>Pengajuan belum bisa dikirim.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="field">
                <label for="jumlah">Jumlah unit</label>
                <input type="number" id="jumlah" name="jumlah"
                       value="{{ old('jumlah', 1) }}" min="1" max="{{ $alat->jumlah }}" required
                       class="{{ $errors->has('jumlah') ? 'invalid' : '' }}">
            </div>

            <div class="field">
                <label for="tanggal_mulai">Tanggal mulai pinjam</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                       value="{{ old('tanggal_mulai') }}"
                       min="{{ date('Y-m-d') }}" required
                       class="{{ $errors->has('tanggal_mulai') ? 'invalid' : '' }}">
            </div>

            <div class="field">
                <label for="tanggal_selesai">Tanggal selesai pinjam</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                       value="{{ old('tanggal_selesai') }}"
                       min="{{ date('Y-m-d') }}" required
                       class="{{ $errors->has('tanggal_selesai') ? 'invalid' : '' }}">
            </div>

            <p class="duration" id="duration" aria-live="polite">
                Pilih tanggal untuk melihat lama peminjaman.
            </p>

            <div class="road"></div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Kirim pengajuan</button>
                <a href="{{ route('alat.index') }}" class="btn-ghost">Batal</a>
            </div>

            <p class="form-note">
                Pengajuan akan berstatus <b>menunggu</b> sampai disetujui admin.
            </p>

        </form>

    </div>

</main>

<script>
    const mulai = document.getElementById('tanggal_mulai');
    const selesai = document.getElementById('tanggal_selesai');
    const info = document.getElementById('duration');

    function hitung() {
        if (mulai.value) {
            selesai.min = mulai.value;
            if (selesai.value && selesai.value < mulai.value) selesai.value = mulai.value;
        }
        if (mulai.value && selesai.value) {
            const hari = Math.round((new Date(selesai.value) - new Date(mulai.value)) / 86400000) + 1;
            info.textContent = 'Lama peminjaman: ' + hari + ' hari';
        } else {
            info.textContent = 'Pilih tanggal untuk melihat lama peminjaman.';
        }
    }

    mulai.addEventListener('change', hitung);
    selesai.addEventListener('change', hitung);
    hitung();
</script>

@endsection