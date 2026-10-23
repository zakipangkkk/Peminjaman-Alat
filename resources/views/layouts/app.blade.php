<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'RODA')</title>

    <link rel="stylesheet" href="{{ asset('css/motorr.css') }}">
</head>

<body>

    {{-- NAVBAR --}}
    <header class="nav">

        {{-- BRAND --}}
        <a href="{{ route('dashboard') }}" class="brand">
            <span class="brand-plate">LAB</span>
            <span class="brand-name">Komputer</span>
        </a>

        {{-- MENU NAVIGASI --}}
        <nav class="nav-actions">

            <a href="{{ route('booking.index') }}" class="nav-link">
                Riwayat
            </a>

            <a href="{{ route('keranjang.index') }}" class="nav-link">
                Keranjang ({{ count(session('keranjang', [])) }})
            </a>

            <a href="{{ route('alat.index') }}" class="nav-link">
                Lihat Alat
            </a>

            {{-- JIKA SUDAH LOGIN --}}
            @auth
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    style="display: inline;"
                >
                    @csrf

                    <button
                        type="submit"
                        class="btn-login"
                        style="cursor: pointer; font-family: inherit;"
                        onclick="return confirm('Apakah kamu yakin ingin logout?')"
                    >
                        Logout
                    </button>
                </form>

            {{-- JIKA BELUM LOGIN --}}
            @else
                <a href="{{ route('login') }}" class="btn-login">
                    Masuk
                </a>
            @endauth

        </nav>

    </header>

    {{-- KONTEN HALAMAN --}}
    @yield('content')

</body>

</html>
```