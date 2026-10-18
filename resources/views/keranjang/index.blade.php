@extends('layouts.app')

@section('title', 'RODA - Keranjang')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/keranjang.css') }}">
@endpush

<style>
    /* public/css/keranjang.css  —  khusus keranjang/index.blade.php */

:root { color-scheme: light; --bg:#EFE9DC; --ink:#1F1D1A; --muted:#6B645A; --amber:#E4A233; --red:#B3371F; --card:#F7F2E7; --ok:#2F7D4F; }

body { background: var(--bg); color: var(--ink); font-family: 'Work Sans', system-ui, sans-serif; line-height: 1.6; }

.keranjang { max-width: 1100px; margin: 0 auto; padding: 40px clamp(16px, 4vw, 40px) 90px; }
.keranjang h1, .keranjang h2 { font-family: 'Oswald', 'Arial Narrow', sans-serif; margin: 0; }
.keranjang :focus-visible { outline: 3px solid var(--amber); outline-offset: 3px; }

.back-link { display: inline-block; color: var(--muted); text-decoration: none; font-weight: 500; margin-bottom: 28px; }
.back-link:hover { color: var(--ink); text-decoration: underline; }
.eyebrow-plate { color: var(--red); font: 600 15px 'Oswald', sans-serif; letter-spacing: .12em; text-transform: uppercase; margin: 0 0 6px; }
.page-title { font-size: clamp(36px, 5vw, 56px); font-weight: 700; line-height: 1.05; margin-bottom: 30px; }

.alert { padding: 14px 16px; margin-bottom: 24px; border: 2px solid var(--ink); }
.alert-success { background: #DDEBDD; border-color: var(--ok); color: #1E5535; font-weight: 500; }
.alert-error { background: #F8E3DC; border-color: var(--red); color: #7A2412; }
.alert ul { margin: 6px 0 0; padding-left: 20px; }

.cart-layout { display: grid; grid-template-columns: 1fr 360px; gap: 44px; align-items: start; }

/* ---------- ITEM ---------- */
.cart-list { display: grid; gap: 26px; }
.cart-item {
    display: grid; grid-template-columns: 110px 1fr auto; align-items: center; gap: 18px;
    background: var(--card); border: 2px solid var(--ink); box-shadow: 7px 7px 0 var(--ink); padding-right: 18px;
}
.cart-thumb {
    position: relative; height: 110px; display: grid; place-items: center; font-size: 38px;
    border-right: 2px solid var(--ink); background: radial-gradient(circle, #EDC77C 0, #F1E3C6 75%);
}
.cart-thumb img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; padding: 8px; mix-blend-mode: multiply; display: block; }
.cart-info h2 { font-size: 22px; font-weight: 600; }
.cart-cat { color: var(--muted); font-size: 14px; margin: 0; }
.cart-stok { font-size: 14px; font-weight: 600; margin: 4px 0 0; }
.cart-stok.ok { color: var(--ok); } .cart-stok.out { color: var(--red); }

.btn-remove {
    background: transparent; color: var(--red); border: 2px solid var(--red); padding: 6px 14px;
    font: 600 14px 'Work Sans', sans-serif; cursor: pointer;
}
.btn-remove:hover { background: var(--red); color: #F7F2E7; }

/* ---------- FORM ---------- */
.cart-form { background: var(--card); border: 2px solid var(--ink); box-shadow: 10px 10px 0 var(--amber); padding: 28px; position: sticky; top: 20px; }
.cart-form h2 { font-size: 28px; font-weight: 600; }
.form-hint { color: var(--muted); font-size: 14px; margin: 2px 0 20px; }
.field { margin-bottom: 18px; }
.field label { display: block; font: 600 16px 'Oswald', sans-serif; letter-spacing: .03em; margin-bottom: 6px; }
.field input { width: 100%; border: 2px solid var(--ink); background: var(--bg); color: var(--ink); padding: 11px 13px; font: 500 16px 'Work Sans', sans-serif; border-radius: 0; }
.field input:focus { outline: 3px solid var(--amber); outline-offset: 2px; }
.duration { color: var(--muted); font-size: 14px; margin: 0; }
.road { border-top: 2px dashed var(--ink); opacity: .6; margin: 22px 0; }
.form-note { color: var(--muted); font-size: 13px; margin: 16px 0 0; }

.btn-primary {
    display: inline-block; background: var(--amber); color: var(--ink); border: 2px solid var(--ink);
    padding: 13px 28px; font: 600 18px 'Oswald', sans-serif; letter-spacing: .03em; cursor: pointer; text-decoration: none;
    box-shadow: 6px 6px 0 var(--ink); transition: transform .12s, box-shadow .12s;
}
.btn-primary:hover { transform: translate(3px, 3px); box-shadow: 3px 3px 0 var(--ink); }

.empty { border: 2px dashed var(--ink); padding: 44px 24px; text-align: center; }
.empty strong { display: block; font: 600 26px 'Oswald', sans-serif; margin-bottom: 4px; }
.empty .btn-primary { margin-top: 20px; }

@media (max-width: 860px) {
    .cart-layout { grid-template-columns: 1fr; }
    .cart-form { position: static; }
}
@media (max-width: 480px) {
    .cart-item { grid-template-columns: 90px 1fr; padding: 0 0 14px; }
    .cart-thumb { height: 90px; }
    .cart-item form { grid-column: 1 / -1; padding: 0 14px; }
}
@media (prefers-reduced-motion: reduce) { * { transition: none !important; } }

/* ---------- JUMLAH (qty) ---------- */
.qty-form { display: flex; align-items: center; gap: 8px; margin-top: 10px; }
.qty-form label { font-size: 13px; color: var(--muted); }
.qty-form input { width: 70px; border: 2px solid var(--ink); background: var(--bg); color: var(--ink); padding: 5px 8px; font: 600 15px 'Work Sans', sans-serif; border-radius: 0; }
.btn-qty { border: 2px solid var(--ink); background: transparent; color: var(--ink); padding: 5px 12px; font: 600 13px 'Work Sans', sans-serif; cursor: pointer; }
.btn-qty:hover { background: var(--amber); }
</style>

@section('content')

<main class="keranjang">

    <a href="{{ route('alat.index') }}" class="back-link">← Tambah alat lain</a>

    <p class="eyebrow-plate">PEMINJAMAN ALAT · CIMAHI &amp; SEKITARNYA</p>
    <h1 class="page-title">Keranjang</h1>

    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

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

    @if ($items->isEmpty())

        <div class="empty">
            <strong>Keranjang masih kosong</strong>
            Pilih alat yang ingin dipinjam, lalu tambahkan ke keranjang.
            <br>
            <a href="{{ route('alat.index') }}" class="btn-primary">Lihat alat</a>
        </div>

    @else

        <div class="cart-layout">

            {{-- DAFTAR ALAT DI KERANJANG --}}
            <section class="cart-list" aria-label="Alat di keranjang">

                @foreach ($items as $alat)
                    <article class="cart-item">

                        <div class="cart-thumb">
                            @if ($alat->foto)
                                <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}">
                            @else
                                <span aria-hidden="true">🧰</span>
                            @endif
                        </div>

                        <div class="cart-info">
                            <h2>{{ $alat->nama_alat }}</h2>
                            <p class="cart-cat">{{ $alat->kategori->nama_kategori ?? '-' }}</p>
                            <p class="{{ $alat->jumlah > 0 ? 'cart-stok ok' : 'cart-stok out' }}">
                                {{ $alat->jumlah > 0 ? $alat->jumlah . ' unit tersedia' : 'Stok habis' }}
                            </p>

                            <form action="{{ route('keranjang.ubah', $alat->id) }}" method="POST" class="qty-form">
                                @csrf
                                @method('PATCH')
                                <label for="qty-{{ $alat->id }}">Jumlah</label>
                                <input type="number" id="qty-{{ $alat->id }}" name="jumlah"
                                       value="{{ $alat->qty }}" min="1" max="{{ $alat->jumlah }}">
                                <button type="submit" class="btn-qty">Ubah</button>
                            </form>
                        </div>

                        <form action="{{ route('keranjang.hapus', $alat->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove" aria-label="Hapus {{ $alat->nama_alat }}">Hapus</button>
                        </form>

                    </article>
                @endforeach

            </section>

            {{-- FORM TANGGAL --}}
            <form action="{{ route('keranjang.checkout') }}" method="POST" class="cart-form" novalidate>
                @csrf

                <h2>Ajukan {{ $items->count() }} jenis alat</h2>
                <p class="form-hint">Semua alat memakai tanggal peminjaman yang sama.</p>

                <div class="field">
                    <label for="tanggal_mulai">Tanggal mulai pinjam</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                           value="{{ old('tanggal_mulai') }}" min="{{ date('Y-m-d') }}" required>
                </div>

                <div class="field">
                    <label for="tanggal_selesai">Tanggal selesai pinjam</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                           value="{{ old('tanggal_selesai') }}" min="{{ date('Y-m-d') }}" required>
                </div>

                <p class="duration" id="duration" aria-live="polite">Pilih tanggal untuk melihat lama peminjaman.</p>

                <div class="road"></div>

                <button type="submit" class="btn-primary">Kirim pengajuan</button>
                <p class="form-note">Semua alat dikirim sebagai satu pengajuan dengan status <b>menunggu</b>.</p>
            </form>

        </div>

    @endif

</main>

<script>
    const mulai = document.getElementById('tanggal_mulai');
    const selesai = document.getElementById('tanggal_selesai');
    const info = document.getElementById('duration');

    if (mulai && selesai) {
        const hitung = () => {
            if (mulai.value) {
                selesai.min = mulai.value;
                if (selesai.value && selesai.value < mulai.value) selesai.value = mulai.value;
            }
            info.textContent = (mulai.value && selesai.value)
                ? 'Lama peminjaman: ' + (Math.round((new Date(selesai.value) - new Date(mulai.value)) / 86400000) + 1) + ' hari'
                : 'Pilih tanggal untuk melihat lama peminjaman.';
        };
        mulai.addEventListener('change', hitung);
        selesai.addEventListener('change', hitung);
        hitung();
    }
</script>

@endsection