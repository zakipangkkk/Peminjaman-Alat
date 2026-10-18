

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

    .roda-field input{
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

    .roda-field input:focus{
        box-shadow:4px 4px 0 var(--roda-orange);
        transform:translate(-2px,-2px);
    }

    .roda-field-row{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:20px;
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

    .roda-errors ul{
        margin:0;
        padding-left:20px;
    }

    .roda-login{
        margin-top:26px;
        text-align:center;
        color:var(--roda-muted);
        font-size:14px;
    }

    .roda-login a{
        color:var(--roda-dark);
        font-weight:800;
        text-decoration:none;
        border-bottom:2px solid var(--roda-orange);
    }

    @media(max-width:560px){
        .roda-field-row{
            grid-template-columns:1fr;
        }

        .roda-card{
            padding:24px;
        }

        .roda-title{
            font-size:32px;
        }

        .roda-actions{
            flex-direction:column;
            align-items:stretch;
        }

        .roda-btn{
            width:100%;
            box-sizing:border-box;
        }

        .roda-btn-cancel{
            text-align:center;
        }
    }
</style>

<div class="roda-wrap">

```
<div class="roda-container">

    <span class="roda-eyebrow">
        RODA · Register
    </span>

    <h2 class="roda-title">
        Buat Akun
    </h2>

    <p class="roda-subtitle">
        Daftarkan akun untuk dapat melakukan peminjaman alat.
    </p>

    <div class="roda-card">

        {{-- ERROR VALIDASI --}}

        @if ($errors->any())

            <div class="roda-errors">

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <hr class="roda-divider">


        {{-- FORM REGISTER --}}

        <form action="{{ route('register.process') }}"
              method="POST">

            @csrf


            {{-- USERNAME --}}

            <div class="roda-field">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan username"
                    required
                >

            </div>


            {{-- EMAIL --}}

            <div class="roda-field">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                >

            </div>


            {{-- NO TELEPON --}}

            <div class="roda-field">

                <label for="no_telfon">
                    No. Telepon
                </label>

                <input
                    type="text"
                    id="no_telfon"
                    name="no_telfon"
                    value="{{ old('no_telfon') }}"
                    placeholder="Contoh: 081234567890"
                    required
                >

            </div>


            {{-- PASSWORD --}}

            <div class="roda-field-row">

                <div class="roda-field">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >

                </div>


                {{-- KONFIRMASI PASSWORD --}}

                <div class="roda-field">

                    <label for="password_confirmation">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        required
                    >

                </div>

            </div>


            {{-- ACTION --}}

            <div class="roda-actions">

                <button type="submit" class="roda-btn">
                    Daftar
                </button>

                <a href="{{ route('login') }}"
                   class="roda-btn-cancel">
                    Sudah punya akun?
                </a>

            </div>

        </form>


        <div class="roda-login">

            Dengan mendaftar, kamu dapat login dan mengajukan
            peminjaman alat.

        </div>

    </div>

</div>
```

</div>


