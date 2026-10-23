```blade
@extends('layouts.master')

@section('title', 'Edit Kategori')

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
    }

    .kategori-page {
        padding: 28px;
        color: var(--roda-dark);
    }

    .kategori-header {
        margin-bottom: 24px;
    }

    .kategori-header h2 {
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 800;
    }

    .kategori-header p {
        margin: 0;
        color: var(--roda-muted);
        font-size: 14px;
    }

    .kategori-card {
        max-width: 650px;
        background: #fff;
        border: 1px solid var(--roda-cream-2);
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 8px 24px rgba(24, 20, 16, 0.06);
    }

    .form-label {
        display: block;
        margin-bottom: 9px;
        font-size: 14px;
        font-weight: 700;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 13px 15px;
        border: 1px solid #d8d2c5;
        border-radius: 10px;
        background: #fff;
        color: var(--roda-dark);
        font-size: 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .form-control:focus {
        border-color: var(--roda-orange);
        box-shadow: 0 0 0 3px rgba(240, 169, 46, 0.18);
    }

    .form-error {
        margin-top: 7px;
        color: var(--roda-red);
        font-size: 13px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 25px;
        flex-wrap: wrap;
    }

    .btn-kategori {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: .2s;
    }

    .btn-save {
        background: var(--roda-orange);
        color: var(--roda-dark);
    }

    .btn-save:hover {
        background: var(--roda-orange-dark);
    }

    .btn-cancel {
        background: var(--roda-cream-2);
        color: var(--roda-dark);
    }

    .btn-cancel:hover {
        background: #dcd5c5;
    }

    @media (max-width: 600px) {
        .kategori-page {
            padding: 16px;
        }

        .kategori-card {
            padding: 20px;
        }
    }
</style>

<div class="kategori-page">

    <div class="kategori-header">
        <h2>Edit Kategori</h2>
        <p>Perbarui informasi kategori alat laboratorium komputer.</p>
    </div>

    <div class="kategori-card">

        <form action="{{ route('admin.kategori.update', $kategori->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div>
                <label for="nama_kategori" class="form-label">
                    Nama Kategori
                </label>

                <input
                    type="text"
                    id="nama_kategori"
                    name="nama_kategori"
                    class="form-control"
                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                    placeholder="Contoh: Perangkat Komputer"
                    required
                >

                @error('nama_kategori')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-kategori btn-save">
                    Simpan Perubahan
                </button>

                <a href="{{ route('admin.kategori.index') }}"
                   class="btn-kategori btn-cancel">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

@endsection
```