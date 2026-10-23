<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'RODA')</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @stack('styles')
</head>

<body>

    <div class="shell">

        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')

        {{-- ISI HALAMAN --}}
        <main class="main">
            @yield('content')
        </main>

    </div>

</body>
</html>