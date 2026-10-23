
@extends('layouts.master')

@section('title', 'Tambah Kategori')

@section('content')

<style>
    :root {
        --roda-cream: #efebdf;
        --roda-cream-2: #e8e3d3;
        --roda-dark: #181410;
        --roda-orange: #f0a92e;
        --roda-orange-dark: #d98f18;
        --roda-red: #c2402c;
        --roda-muted: #8a8478;
        --roda-border: #181410;
    }

    .roda-kategori-wrap {
        background: var(--roda-cream);
        min-height: 100vh;
        padding: 48px 24px;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        color: var(--roda-dark);
        box-sizing: border-box;
    }

    .roda-kategori-wrap * {
        box-sizing: border-box;
    }

    .roda-kategori-container {
        max-width: 760px;
        margin: 0 auto;
    }

    .roda-kategori-eyebrow {
        display: inline-block;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--roda-red);
        margin-bottom: 10px;
    }

    .roda-kategori-title {
        font-size: 38px;
        font-weight: 900;
        line-height: 1.1;
        margin: 0 0 8px;
        color: var(--roda-dark);
    }

    .roda-kategori-subtitle {
        color: var(--roda-muted);
        font-size: 15px;
        line-height: 1.7;
        margin: 0 0 32px;
    }

    .roda-kategori-card {
        background: #fbf9f3;
        border: 3px solid var(--roda-border);
        border-radius: 14px;
        padding: 36px;
        box-shadow: 8px 8px 0 var(--roda-border);
    }

    .roda-kategori-card-heading {
        margin: 0 0 8px;
        font-size: 20px;
        font-weight: 850;
    }

    .roda-kategori-card-description {
        margin: 0 0 24px;
        font-size: 13px;
        line-height: 1.7;
        color: var(--roda-muted);
    }

    .roda-kategori-divider {
        border: none;
        border-top: 2px dashed #c9c2ae;
        margin: 0 0 28px;
    }

    .roda-kategori-field {
        margin-bottom: 22px;
    }

    .roda-kategori-field label {
        display: block;
        font-weight: 800;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: 8px;
    }

    .roda-kategori-field input {
        display: block;
        width: 100%;
        padding: 13px 14px;
        font-size: 15px;
        font-family: inherit;
        color: var(--roda-dark);
        background: #fff;
        border: 2px solid var(--roda-border);
        border-radius: 8px;
        outline: none;
        transition: box-shadow .15s ease, transform .15s ease;
    }

    .roda-kategori-field input:focus {
        box-shadow: 4px 4px 0 var(--roda-orange);
        transform: translate(-2px, -2px);
    }

    .roda-kategori-field input::placeholder {
        color: #aaa396;
    }

    .roda-kategori-help {
        display: block;
        color: var(--roda-muted);
        font-size: 12px;
        line-height: 1.6;
        margin-top: 8px;
    }

    .roda-kategori-actions {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-top: 32px;
        flex-wrap: wrap;
    }

    .roda-kategori-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--roda-orange);
        color: var(--roda-dark);
        font-weight: 800;
        font-size: 15px;
        padding: 14px 28px;
        border: 2px solid var(--roda-border);
        border-radius: 8px;
        box-shadow: 5px 5px 0 var(--roda-border);
        cursor: pointer;
        text-decoration: none;
        font-family: inherit;
        transition: transform .12s ease, box-shadow .12s ease;
    }

    .roda-kategori-btn:hover {
        background: var(--roda-orange-dark);
        color: var(--roda-dark);
        transform: translate(2px, 2px);
        box-shadow: 3px 3px 0 var(--roda-border);
    }

    .roda-kategori-btn-cancel {
        background: transparent;
        color: var(--roda-dark);
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        border-bottom: 2px solid var(--roda-dark);
        padding-bottom: 2px;
    }

    .roda-kategori-btn-cancel:hover {
        color: var(--roda-red);
        border-color: var(--roda-red);
    }

    .roda-kategori-errors {
        background: #fbe3df;
        border: 2px solid var(--roda-red);
        color: #7c2419;
        border-radius: 8px;
        padding: 14px 18px;
        margin-bottom: 24px;
        font-size: 14px;
    }

    .roda-kategori-errors strong {
        display: block;
        margin-bottom: 8px;
    }

    .roda-kategori-errors ul {
        margin: 0;
        padding-left: 18px;
    }

    .roda-kategori-errors li + li {
        margin-top: 5px;
    }

    @media (max-width: 560px) {
        .roda-kategori-wrap {
            padding: 30px 18px;
        }

        .roda-kategori-title {
            font-size: 30px;
        }

        .roda-kategori-card {
            padding: 24px 20px;
            box-shadow: 5px 5px 0 var(--roda-border);
        }

        .roda-kategori-actions {
            align-items: flex-start;
            gap: 18px;
        }

        .roda-kategori-btn {
            padding: 12px 20px;
        }
    }
</style>

<div class="roda-kategori-wrap">

    <div class="roda-kategori-container">

        {{-- Header --}}
        <span class="roda-kategori-eyebrow">
            Panel Admin · Inventaris
        </span>

        <h1 class="roda-kategori-title">
            Tambah Kategori
        </h1>

        <p class="roda-kategori-subtitle">
            Tambahkan kategori baru untuk mengelompokkan alat
            laboratorium komputer agar inventaris lebih teratur.
        </p>

        {{-- Form Card --}}
        <div class="roda-kategori-card">

            <h2 class="roda-kategori-card-heading">
                Informasi Kategori
            </h2>

            <p class="roda-kategori-card-description">
                Isi nama kategori di bawah ini, kemudian simpan
                untuk menambahkan kategori ke dalam sistem.
            </p>

            <hr class="roda-kategori-divider">

            {{-- Error validasi --}}
            @if ($errors->any())
                <div class="roda-kategori-errors">
                    <strong>Periksa kembali data yang dimasukkan:</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form tambah kategori --}}
            <form action="{{ route('admin.kategori.store') }}"
                  method="POST">

                @csrf

                <div class="roda-kategori-field">
                    <label for="nama_kategori">
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        id="nama_kategori"
                        name="nama_kategori"
                        value="{{ old('nama_kategori') }}"
                        placeholder="Contoh: Perangkat Komputer"
                        maxlength="255"
                        required
                        autofocus
                    >

                    <small class="roda-kategori-help">
                        Contoh kategori: Laptop, Monitor, Keyboard,
                        Mouse, atau Perangkat Jaringan.
                    </small>
                </div>

                {{-- Tombol --}}
                <div class="roda-kategori-actions">

                    <button type="submit"
                            class="roda-kategori-btn">
                        Simpan Kategori
                    </button>

                    <a href="{{ route('admin.kategori.index') }}"
                       class="roda-kategori-btn-cancel">
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
