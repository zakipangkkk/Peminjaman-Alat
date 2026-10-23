<nav class="petugas-menu" aria-label="Menu petugas">
    <a href="{{ route('petugas.dashboard') }}"
       class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('petugas.booking.index') }}"
       class="{{ request()->routeIs('petugas.booking.*') ? 'active' : '' }}">Verifikasi</a>
    <a href="{{ route('petugas.pengembalian.index') }}"
       class="{{ request()->routeIs('petugas.pengembalian.*') ? 'active' : '' }}">Pengembalian</a>
    <a href="{{ route('petugas.laporan.index') }}"
       class="{{ request()->routeIs('petugas.laporan.*') ? 'active' : '' }}">Laporan</a>
</nav>