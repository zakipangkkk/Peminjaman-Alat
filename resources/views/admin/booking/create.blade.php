@extends('layouts.master')

@section('title', 'RODA - Tambah peminjaman')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/admin-crud.css') }}">
@endpush

@section('content')

<main class="crud crud-narrow">

    <a href="{{ route('admin.booking.index') }}" class="back-link">← Kembali ke data peminjaman</a>

    <p class="eyebrow-plate">PANEL ADMIN · PEMINJAMAN ALAT</p>
    <h1 class="page-title">Tambah peminjaman</h1>
    <p class="page-sub">Catat peminjaman baru atas nama peminjam.</p>

    @include('admin._alerts')

    @include('admin.booking._form')

</main>

@endsection