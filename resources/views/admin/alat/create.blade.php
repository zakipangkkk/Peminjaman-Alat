@extends('layouts.master')

@section('title', 'Tambah Motor')

@section('content')

<style>
    :root{
        --roda-cream:#efebdf;
        --roda-cream-2:#e8e3d3;
        --roda-dark:#181410;
        --roda-orange:#f0a92e;
        --roda-orange-dark:#d98f18;
        --roda-red:#c2402c;
        --roda-muted:#8a8478;
        --roda-border:#181410;
    }

    .roda-wrap{
        background:var(--roda-cream);
        min-height:100vh;
        padding:48px 24px;
        font-family:'Segoe UI',system-ui,-apple-system,sans-serif;
        color:var(--roda-dark);
    }

    .roda-container{
        max-width:760px;
        margin:0 auto;
    }

    .roda-eyebrow{
        display:inline-block;
        font-size:13px;
        font-weight:800;
        letter-spacing:.08em;
        text-transform:uppercase;
        color:var(--roda-red);
        margin-bottom:10px;
    }

    .roda-title{
        font-size:38px;
        font-weight:900;
        line-height:1.1;
        margin:0 0 8px;
        color:var(--roda-dark);
    }

    .roda-subtitle{
        color:var(--roda-muted);
        font-size:15px;
        margin-bottom:32px;
    }

    .roda-card{
        position:relative;
        background:#fbf9f3;
        border:3px solid var(--roda-border);
        border-radius:14px;
        padding:36px;
        box-shadow:8px 8px 0 var(--roda-border);
    }

    .roda-divider{
        border:none;
        border-top:2px dashed #c9c2ae;
        margin:0 0 28px;
    }

    .roda-field{
        margin-bottom:22px;
    }

    .roda-field label{
        display:block;
        font-weight:800;
        font-size:13px;
        text-transform:uppercase;
        letter-spacing:.04em;
        margin-bottom:8px;
        color:var(--roda-dark);
    }

    .roda-field input[type="text"],
    .roda-field select{
        width:100%;
        padding:12px 14px;
        font-size:15px;
        font-family:inherit;
        color:var(--roda-dark);
        background:#fff;
        border:2px solid var(--roda-border);
        border-radius:8px;
        outline:none;
        transition:box-shadow .15s ease, transform .15s ease;
        appearance:none;
        -webkit-appearance:none;
    }

    .roda-field select{
        background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='14' height='9' viewBox='0 0 14 9'><path d='M1 1l6 6 6-6' stroke='%23181410' stroke-width='2' fill='none' fill-rule='evenodd'/></svg>");
        background-repeat:no-repeat;
        background-position:right 14px center;
        padding-right:38px;
    }

    .roda-field input[type="text"]:focus,
    .roda-field select:focus{
        box-shadow:4px 4px 0 var(--roda-orange);
        transform:translate(-2px,-2px);
    }

    .roda-field-row{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:20px;
    }

    @media (max-width:560px){
        .roda-field-row{ grid-template-columns:1fr; }
    }

    /* file input styled like an upload dropzone */
    .roda-file{
        border:2px dashed var(--roda-border);
        border-radius:8px;
        padding:18px;
        background:var(--roda-cream-2);
        text-align:center;
        cursor:pointer;
        position:relative;
    }

    .roda-file input[type="file"]{
        position:absolute;
        inset:0;
        opacity:0;
        cursor:pointer;
        width:100%;
        height:100%;
    }

    .roda-file-label{
        font-size:14px;
        color:var(--roda-muted);
        font-weight:600;
    }

    .roda-file-label strong{
        color:var(--roda-dark);
    }

    .roda-actions{
        display:flex;
        align-items:center;
        gap:18px;
        margin-top:32px;
    }

    .roda-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:var(--roda-orange);
        color:var(--roda-dark);
        font-weight:800;
        font-size:15px;
        padding:14px 28px;
        border:2px solid var(--roda-border);
        border-radius:8px;
        box-shadow:5px 5px 0 var(--roda-border);
        cursor:pointer;
        text-decoration:none;
        transition:transform .12s ease, box-shadow .12s ease;
    }

    .roda-btn:hover{
        background:var(--roda-orange-dark);
        transform:translate(2px,2px);
        box-shadow:3px 3px 0 var(--roda-border);
    }

    .roda-btn:active{
        transform:translate(5px,5px);
        box-shadow:0 0 0 var(--roda-border);
    }

    .roda-btn-cancel{
        background:transparent;
        color:var(--roda-dark);
        font-weight:700;
        font-size:15px;
        text-decoration:none;
        border-bottom:2px solid var(--roda-dark);
        padding-bottom:2px;
    }

    .roda-btn-cancel:hover{
        color:var(--roda-red);
        border-color:var(--roda-red);
    }

    .roda-errors{
        background:#fbe3df;
        border:2px solid var(--roda-red);
        color:#7c2419;
        border-radius:8px;
        padding:14px 18px;
        margin-bottom:24px;
        font-size:14px;
    }

    .roda-errors ul{
        margin:0;
        padding-left:18px;
    }
    /* =========================
   PREVIEW FOTO MOTOR
========================= */

#preview-container {
    margin-top: 16px;
    padding: 10px;
    width: 280px;
    background: #f5f1e8;
    border: 1px solid #ddd6c8;
    border-radius: 14px;
}

#preview {
    display: block;
    width: 260px;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #d5cec0;
}
</style>

<div class="roda-wrap">
    <div class="roda-container">

        <span class="roda-eyebrow">Panel Admin &middot; Data Motor</span>
        <h2 class="roda-title">Tambah Alat Baru</h2>
        <p class="roda-subtitle">Lengkapi data alat di bawah ini untuk menambahkannya ke daftar armada RODA.</p>

        <div class="roda-card">

            @if ($errors->any())
                <div class="roda-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <hr class="roda-divider">


<form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="roda-field">
        <label>Nama Alat</label>
        <input
            type="text"
            name="nama_alat"
            value="{{ old('nama_alat') }}"
            placeholder="Contoh: Laptop ASUS"
            required
        >
    </div>

    <div class="roda-field-row">
        <div class="roda-field">
            <label>Jumlah Alat</label>
            <input
                type="number"
                name="jumlah"
                value="{{ old('jumlah') }}"
                placeholder="Contoh: 10"
                min="0"
                required
            >
        </div>

        <div class="roda-field">
            <label>Kategori</label>
            <select name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>

                @foreach ($kategori as $item)
                    <option
                        value="{{ $item->id }}"
                        {{ old('kategori_id') == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="roda-field">
        <label>Foto Alat</label>

        <div class="roda-file">
            <input
                type="file"
                name="foto"
                id="foto"
                accept="image/jpeg,image/png,image/jpg"
                required
            >

            <div class="roda-file-label">
                <strong>Klik untuk unggah</strong>
                atau pilih foto alat di sini
            </div>
        </div>
    </div>

    <div id="preview-container" style="display: none; margin-top: 15px;">
        <img
            id="preview"
            src="#"
            alt="Preview Foto Alat"
            style="max-width: 250px; border-radius: 10px;"
        >
    </div>

    <div class="roda-actions">
        <button type="submit" class="roda-btn">
            Simpan Alat
        </button>

        <a href="{{ route('admin.alat.index') }}" class="roda-btn-cancel">
            Batal
        </a>
    </div>
</form>

<script>
    document.getElementById('foto').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const preview = document.getElementById('preview');
            const container = document.getElementById('preview-container');

            preview.src = URL.createObjectURL(file);
            container.style.display = 'block';
        }
    });
</script>


            </form>

        </div>
    </div>
</div>

@endsection