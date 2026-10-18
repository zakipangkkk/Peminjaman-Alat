@extends('layouts.master')

@section('title', 'Booking Motor')

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
    }

    .roda-subtitle{
        color:var(--roda-muted);
        font-size:15px;
        margin-bottom:32px;
    }

    .roda-card{
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
    }

    .roda-field input,
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
        box-sizing:border-box;
    }

    .roda-field input:focus,
    .roda-field select:focus{
        box-shadow:4px 4px 0 var(--roda-orange);
        transform:translate(-2px,-2px);
    }

    .roda-field-row{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:20px;
    }

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

    #preview-container{
        margin-top:16px;
        padding:10px;
        width:280px;
        background:#f5f1e8;
        border:1px solid #ddd6c8;
        border-radius:14px;
    }

    #preview{
        display:block;
        width:260px;
        height:180px;
        object-fit:cover;
        border-radius:10px;
        border:1px solid #d5cec0;
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
    }

    .roda-btn:hover{
        background:var(--roda-orange-dark);
    }

    .roda-btn-cancel{
        color:var(--roda-dark);
        font-weight:700;
        font-size:15px;
        text-decoration:none;
        border-bottom:2px solid var(--roda-dark);
        padding-bottom:2px;
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

    @media(max-width:560px){
        .roda-field-row{
            grid-template-columns:1fr;
        }
    }
</style>

<div class="roda-wrap">
    <div class="roda-container">

```
    <span class="roda-eyebrow">
        RODA · Booking Motor
    </span>

    <h2 class="roda-title">
        Booking Motor
    </h2>

    <p class="roda-subtitle">
        Lengkapi data booking dan upload dokumen untuk melakukan penyewaan motor.
    </p>

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

        <form action="{{ route('booking.store') }}"
              method="POST"

            @csrf

            {{-- MOTOR --}}
<div class="roda-field">
    <label>Motor</label>

    <input
        type="text"
        value="{{ $motor->nama }}"
        readonly
    >

    <input
        type="hidden"
        name="motor_id"
        value="{{ $motor->id }}"
    >
</div>

            {{-- TANGGAL --}}
            <div class="roda-field-row">

                <div class="roda-field">
                    <label>Tanggal Mulai</label>

                    <input
                        type="date"
                        name="tanggal_mulai"
                        value="{{ old('tanggal_mulai') }}"
                        required
                    >
                </div>

                <div class="roda-field">
                    <label>Tanggal Selesai</label>

                    <input
                        type="date"
                        name="tanggal_selesai"
                        value="{{ old('tanggal_selesai') }}"
                        required
                    >
                </div>

            </div>

            {{-- DOKUMEN --}}


            {{-- PREVIEW --}}
            <div id="preview-container" style="display:none;">

                <img
                    id="preview"
                    src="#"
                    alt="Preview Dokumen"
                >

            </div>

            {{-- ACTION --}}
            <div class="roda-actions">

                <button type="submit" class="roda-btn">
                    Ajukan Booking
                </button>

                <a href="{{ url()->previous() }}"
                   class="roda-btn-cancel">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>
```

</div>

<script>
    document.getElementById('dokumen').addEventListener('change', function(event) {

        const file = event.target.files[0];

        if (file) {

            const preview = document.getElementById('preview');
            const container = document.getElementById('preview-container');

            preview.src = URL.createObjectURL(file);

            container.style.display = 'block';
        }

    });
</script>

@endsection
