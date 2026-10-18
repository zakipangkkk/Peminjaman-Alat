@extends('layouts.app')

@section('title', $alat->nama_alat)

@section('content')

<main class="detail-view">

```
<a href="{{ route('alat.index') }}"
   class="back-link">

    ← Kembali ke daftar

</a>


<div class="detail-grid">

    {{-- GAMBAR --}}

    <div class="detail-art">

        <div class="hero-glow"></div>

        @if ($alat->foto)

            <img src="{{ asset('storage/' . $alat->foto) }}"
                 alt="{{ $alat->nama_alat }}"
                 class="detail-alat">

        @else

            <div class="detail-alat">
                🧰
            </div>

        @endif

    </div>


    {{-- INFORMASI --}}

    <div class="detail-info">

        <p class="eyebrow-plate">

            {{ strtoupper($alat->kategori->nama_kategori) }}

        </p>


        <h1>
            {{ $alat->nama_alat }}
        </h1>


        <div class="spec-list">

            <div class="spec">
                <strong>Kategori</strong>
                {{ $alat->kategori->nama_kategori }}
            </div>

            <div class="spec">
                <strong>Jumlah</strong>
                {{ $alat->jumlah }} unit
            </div>

        </div>


        <div class="road"></div>


        <div class="order-box">

            <div>

                <span class="price price-lg">
                    {{ $alat->jumlah }} unit
                </span>

                <p class="avail">

                    @if ($alat->jumlah > 0)

                        ✓ Tersedia untuk dipinjam

                    @else

                        ✕ Stok sedang habis

                    @endif

                </p>

            </div>


            @if ($alat->jumlah > 0)

                <a href="{{ route('booking.create', $alat->id) }}"
                   class="btn-primary">

                    Pinjam Sekarang

                </a>

            @else

                <button class="btn-primary"
                        disabled>

                    Tidak Tersedia

                </button>

            @endif

        </div>

    </div>

</div>
```

</main>

@endsection
