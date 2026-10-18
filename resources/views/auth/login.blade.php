
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk — RODA</title>

<style>
  :root{
    --cream:#EDE8DC;
    --cream-2:#F5F2EA;
    --ink:#1C1B18;
    --ink-soft:#6b675e;
    --red:#B23A2E;
    --orange:#E3A234;
    --orange-dark:#c98a1f;
    --line:#d8d2c2;
    --card-shadow: 6px 6px 0 rgba(28,27,24,0.9);
  }
  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}
  body{
    background:var(--cream);
    color:var(--ink);
    font-family:'Helvetica Neue', Arial, sans-serif;
    min-height:100vh;
    display:flex;
    flex-direction:column;
  }

  header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:22px 48px;
    border-bottom:1px solid var(--ink);
  }
  .brand{
    display:flex;
    align-items:center;
    gap:10px;
    font-weight:800;
    font-size:20px;
    letter-spacing:0.5px;
  }
  .brand-badge{
    width:34px;height:34px;
    background:var(--ink);
    color:#fff;
    display:flex;align-items:center;justify-content:center;
    font-weight:800;
    font-size:13px;
    border-radius:6px;
  }
  header nav{
    font-size:15px;
    color:var(--ink);
  }
  header nav a{
    color:var(--ink);
    text-decoration:none;
  }

  main{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:56px 24px;
  }

  .wrap{
    display:flex;
    max-width:980px;
    width:100%;
    gap:64px;
    align-items:center;
  }

  .side-copy{
    flex:1;
    min-width:280px;
  }
  .eyebrow{
    color:var(--red);
    font-weight:700;
    font-size:13px;
    letter-spacing:0.4px;
    margin-bottom:14px;
  }
  .side-copy h1{
    font-size:44px;
    line-height:1.08;
    margin:0 0 18px 0;
    font-weight:800;
  }
  .side-copy p{
    color:var(--ink-soft);
    font-size:16px;
    line-height:1.55;
    max-width:34ch;
    margin:0 0 28px 0;
  }
  .mini-card{
    display:inline-flex;
    align-items:center;
    gap:12px;
    background:var(--cream-2);
    border:1px solid var(--line);
    padding:12px 16px;
    border-radius:10px;
  }
  .mini-card .plate{
    background:var(--ink);
    color:#fff;
    font-weight:700;
    font-size:12px;
    padding:5px 9px;
    border-radius:4px;
    letter-spacing:1px;
  }
  .mini-card span.txt{
    font-size:13px;
    color:var(--ink-soft);
  }

  .panel{
    flex:1;
    min-width:320px;
    max-width:400px;
    background:var(--cream-2);
    border:1px solid var(--ink);
    border-radius:14px;
    padding:38px 34px;
    box-shadow:var(--card-shadow);
  }
  .panel h2{
    margin:0 0 6px 0;
    font-size:26px;
    font-weight:800;
  }
  .panel .sub{
    color:var(--ink-soft);
    font-size:14px;
    margin:0 0 26px 0;
  }

  .field{
    margin-bottom:18px;
  }
  .field label{
    display:block;
    font-size:13px;
    font-weight:700;
    margin-bottom:7px;
  }
  .field input{
    width:100%;
    padding:12px 14px;
    border:1px solid var(--ink);
    border-radius:8px;
    background:#fff;
    font-size:15px;
    color:var(--ink);
    font-family:inherit;
  }
  .field input:focus{
    outline:3px solid var(--orange);
    outline-offset:1px;
  }
  .field input::placeholder{
    color:#b3ad9e;
  }

  .row-between{
    display:flex;
    align-items:center;
    justify-content:space-between;
    font-size:13px;
    margin:-4px 0 22px 0;
  }
  .row-between label{
    display:flex;
    align-items:center;
    gap:7px;
    color:var(--ink-soft);
    cursor:pointer;
  }
  .row-between a{
    color:var(--red);
    text-decoration:none;
    font-weight:600;
  }

  .btn-login{
    width:100%;
    background:var(--orange);
    color:var(--ink);
    border:1px solid var(--ink);
    font-weight:800;
    font-size:15px;
    padding:13px 16px;
    border-radius:9px;
    cursor:pointer;
    box-shadow:3px 3px 0 rgba(28,27,24,0.9);
    transition:transform .12s ease;
    font-family:inherit;
  }
  .btn-login:hover{
    background:var(--orange-dark);
  }
  .btn-login:active{
    transform:translate(2px,2px);
    box-shadow:1px 1px 0 rgba(28,27,24,0.9);
  }

  .divider{
    display:flex;
    align-items:center;
    gap:12px;
    margin:24px 0;
    color:var(--ink-soft);
    font-size:12px;
  }
  .divider::before,.divider::after{
    content:"";
    flex:1;
    height:0;
    border-top:1px dashed var(--line);
  }

  .signup-line{
    text-align:center;
    font-size:14px;
    color:var(--ink-soft);
    margin-top:4px;
  }
  .signup-line a{
    color:var(--red);
    font-weight:700;
    text-decoration:none;
  }

  .error{
    display:none;
    background:#FBEAE7;
    border:1px solid var(--red);
    color:var(--red);
    font-size:13px;
    padding:10px 12px;
    border-radius:8px;
    margin-bottom:18px;
  }
  .error.show{display:block;}

  @media (max-width:760px){
    .wrap{flex-direction:column;}
    header{padding:18px 22px;}
    .side-copy{text-align:center;}
    .side-copy p{margin-left:auto;margin-right:auto;}
    .mini-card{margin:0 auto;}
    .side-copy h1{font-size:32px;}
  }
</style>
</head>
<body>

<header>
  <div class="brand">
    <div class="brand-badge">Lab</div>
    Komputer
  </div>
  <nav><a href="#">Lihat Alat</a></nav>
</header>

<main>
  <div class="wrap">

    <div class="side-copy">
      <div class="eyebrow">PINJAM ALAT HARIAN</div>
      <h1>Masuk dulu, baru gas...</h1>
      <p>Kelola pesanan, lihat riwayat sewa, dan booking alat lebih cepat setelah masuk akun.</p>
      <div class="mini-card">
        <div class="plate">Siap alat</div>
        <span class="txt">Alat tersedia hari ini</span>
      </div>
    </div>

<form class="panel" action="{{ route('login.process') }}" method="POST">
    @csrf

    <h2>Masuk</h2>
    <p class="sub">Masukkan akunmu untuk lanjut peminjaman Alat.</p>

    @if ($errors->any())
        <div class="error show">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="field">
        <label for="username">Username</label>
        <input
            type="text"
            id="username"
            name="username"
            value="{{ old('username') }}"
            placeholder="Masukkan username"
            autocomplete="username"
            required
        >
    </div>

    <div class="field">
        <label for="password">Kata sandi</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="••••••••"
            autocomplete="current-password"
            required
        >
    </div>

    <div class="row-between">
        <label>
            <input type="checkbox" name="remember">
            Ingat saya
        </label>

    </div>

    <button type="submit" class="btn-login">
        Masuk
    </button>

    <div class="divider">atau</div>

    <p class="signup-line">
        Belum punya akun? <a href="{{route('register')}}">Daftar sekarang</a>
    </p>
</form>

  </div>
</main>

</body>
</html>