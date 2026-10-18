<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'RODA')</title>

    <link rel="stylesheet" href="{{ asset('css/motorr.css') }}">
</head>

<body>

    <header class="nav">

        <a href="{{ route('dashboard') }}" class="brand">
            <span class="brand-plate">LAB</span>
            <span class="brand-name">Komputer</span>
        </a>

        <nav class="nav-actions">

        <a href="{{route('booking.index')}}"
            class="nav-link">
            riwayat
        </a>

        <a href="{{ route('keranjang.index') }}">
    Keranjang ({{ count(session('keranjang', [])) }})
</a>
            

            <a href="{{ route('alat.index') }}"
               class="nav-link">
                Lihat Alat
            </a>

            <a href="{{ route('login') }}"
               class="btn-login">
                Masuk
            </a>



        </nav>

    </header>

    @yield('content')

</body>

</html>