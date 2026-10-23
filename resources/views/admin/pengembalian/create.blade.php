@extends('layouts.master')

@section('title', 'RODA - Tambah pengembalian')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/admin-crud.css') }}">
@endpush

@section('content')

<main class="crud crud-narrow">

    <a href="{{ route('admin.pengembalian.index') }}" class="back-link">← Kembali ke data pengembalian</a>

    <p class="eyebrow-plate">PANEL ADMIN · PEMINJAMAN ALAT</p>
    <h1 class="page-title">Tambah pengembalian</h1>
    <p class="page-sub">Catat alat yang sudah dikembalikan. Stok alat akan bertambah kembali.</p>

    @include('admin._alerts')

    @include('admin.pengembalian._form')

</main>

@endsection