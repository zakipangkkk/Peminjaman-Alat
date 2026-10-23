@extends('layouts.master')

@section('title', 'RODA - Data Peminjaman')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/admin-crud.css') }}">
@endpush

@section('content')

@php
    $label = ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'completed' => 'Selesai'];
@endphp

<main class="crud">

    <p class="eyebrow-plate">PANEL ADMIN · PEMINJAMAN ALAT</p>

    <div class="crud-head">
        <h1 class="page-title">Data peminjaman</h1>
        <a href="{{ route('admin.booking.create') }}" class="btn-amber">+ Tambah peminjaman</a>
    </div>
    <p class="page-sub">Kelola data peminjaman. Persetujuan dan penolakan hanya dilakukan oleh petugas.</p>

    @include('admin._alerts')

    <div class="toolbar">
        <div class="chip-row" role="group" aria-label="Filter status">
            @foreach (['semua' => 'Semua'] + $label as $key => $nama)
                <a href="{{ route('admin.booking.index', ['status' => $key]) }}"
                   class="chip {{ $status === $key ? 'active' : '' }}">{{ $nama }}</a>
            @endforeach
        </div>

    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr><th>#</th><th>Peminjam</th><th>Alat</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse ($bookings as $b)
                    <tr>
                        <td data-label="#">{{ $b->id }}</td>
                        <td data-label="Peminjam">
                            <strong>{{ optional($b->user)->name ?? 'User dihapus' }}</strong>
                        </td>
                        <td data-label="Alat">
                            <ul class="item-list">
                                @foreach ($b->detail as $d)
                                    <li>{{ optional($d->alat)->nama_alat ?? 'Alat dihapus' }} <b>× {{ $d->jumlah }}</b></li>
                                @endforeach
                            </ul>
                        </td>
                        <td data-label="Tanggal">
                            {{ $b->tanggal_mulai->translatedFormat('d M Y') }} –<br>
                            {{ $b->tanggal_selesai->translatedFormat('d M Y') }}
                        </td>
                        <td data-label="Status">
                            <span class="stamp stamp-{{ $b->status }}">{{ $label[$b->status] ?? $b->status }}</span>
                        </td>
                        <td data-label="Aksi">
                            <div class="actions">
                                <a href="{{ route('admin.booking.edit', $b->id) }}" class="btn-act">Edit</a>

                                <form action="{{ route('admin.booking.destroy', $b->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus data peminjaman #{{ $b->id }}?{{ $b->status === 'approved' ? ' Stok alat akan dikembalikan.' : '' }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-no">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row">
                            <strong>Belum ada data peminjaman</strong>
                            Klik "Tambah peminjaman" untuk membuat data baru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pager">
        @if ($bookings->previousPageUrl())<a href="{{ $bookings->previousPageUrl() }}" class="chip">← Sebelumnya</a>@endif
        @if ($bookings->nextPageUrl())<a href="{{ $bookings->nextPageUrl() }}" class="chip">Berikutnya →</a>@endif
    </div>

</main>

@endsection