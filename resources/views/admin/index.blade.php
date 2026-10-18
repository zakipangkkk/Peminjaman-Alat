@extends('layouts.master')

@section('title', 'Dashboard Admin')

@section('content')

<div class="topbar">

    <div>
        <div class="eyebrow">
            Ringkasan · Hari ini
        </div>

        <h1>
            Dashboard
        </h1>
    </div>

    <div class="topbar-right">

        {{-- <a href="{{ route('admin.booking.create') }}" class="btn">
            + Tambah Booking
        </a> --}}

    </div>

</div>


{{-- STATISTIK --}}
<div class="stats">

    <div class="stat-card">
        <div class="label">
            Motor tersedia
        </div>

        <div class="value">
            {{ $alattersedia ?? 0 }}
        </div>

        <div class="delta">
            Unit tersedia
        </div>
    </div>


    <div class="stat-card">
        <div class="label">
            Sedang disewa
        </div>

        <div class="value">
            {{ $alatDisewa ?? 0 }}
        </div>

        <div class="delta">
            Motor sedang disewa
        </div>
    </div>


    <div class="stat-card">
        <div class="label">
            Total motor
        </div>

        <div class="value">
            {{ $totalAlat ?? 0 }}
        </div>

        <div class="delta">
            Seluruh kendaraan
        </div>
    </div>


    <div class="stat-card">
        <div class="label">
            Total pelanggan
        </div>

        <div class="value">
            {{ $totalUser ?? 0 }}
        </div>

        <div class="delta">
            Pengguna terdaftar
        </div>
    </div>

</div>


{{-- PENYEWAAN TERBARU --}}
<div class="panel">

    <div class="panel-head">

        <h2>
            Penyewaan Terbaru
        </h2>

        {{-- <a href="{{ route('admin.booking.index') }}" class="link">
            Lihat semua →
        </a> --}}

    </div>


    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Motor</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>

            @forelse($bookingTerbaru ?? [] as $booking)

            <tr>

                <td>
                    #{{ $booking->id }}
                </td>

                <td>
                    {{ $booking->user->name ?? '-' }}
                </td>

                <td>
                    {{ $booking->motor->nama_motor ?? '-' }}
                </td>

                <td>
                    {{ $booking->waktu_mulai ?? '-' }}
                </td>

                <td>
                    {{ $booking->waktu_selesai ?? '-' }}
                </td>

                <td>
                    <span class="badge">
                        {{ $booking->status }}
                    </span>
                </td>

                <td>
                    Rp{{ number_format($booking->total ?? 0, 0, ',', '.') }}
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="7" style="text-align:center;">
                    Belum ada data penyewaan.
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection