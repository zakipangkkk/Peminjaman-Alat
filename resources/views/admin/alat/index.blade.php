
@extends('layouts.master')

@section('title', 'Data Alat')

@section('content')

<style>
    .alat-admin-page {
        width: 100%;
        padding: 8px 0 24px;
        color: #24211d;
    }

    .alat-admin-page * {
        box-sizing: border-box;
    }

    /* Header halaman */
    .alat-admin-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .alat-admin-eyebrow {
        color: #b47713;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 7px;
    }

    .alat-admin-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 750;
        line-height: 1.3;
        color: #24211d;
    }

    .alat-admin-description {
        margin: 8px 0 0;
        font-size: 14px;
        color: #817b71;
        line-height: 1.6;
    }

    /* Tombol tambah */
    .alat-btn-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 18px;
        border-radius: 10px;
        background: #efa92e;
        color: #241a09;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        border: none;
        transition: 0.2s ease;
        white-space: nowrap;
    }

    .alat-btn-add:hover {
        background: #d99217;
        color: #181410;
        transform: translateY(-1px);
    }

    /* Panel tabel */
    .alat-panel {
        background: #ffffff;
        border: 1px solid #e9e5dc;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(35, 29, 19, 0.04);
    }

    .alat-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 20px 24px;
        border-bottom: 1px solid #eeeae2;
        flex-wrap: wrap;
    }

    .alat-panel-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #29251f;
    }

    .alat-panel-subtitle {
        margin: 5px 0 0;
        font-size: 13px;
        color: #8a8478;
    }

    .alat-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 32px;
        padding: 0 10px;
        border-radius: 8px;
        background: #fbf3df;
        color: #9a6410;
        font-size: 13px;
        font-weight: 700;
    }

    /* Pembungkus tabel */
    .alat-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .alat-table {
        width: 100%;
        min-width: 700px;
        border-collapse: collapse;
        border-spacing: 0;
        margin: 0;
    }

    .alat-table thead {
        background: #faf8f3;
    }

    .alat-table th {
        padding: 15px 20px;
        text-align: left;
        font-size: 11px;
        font-weight: 750;
        color: #797265;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        white-space: nowrap;
        border-bottom: 1px solid #eeeae2;
    }

    .alat-table td {
        padding: 16px 20px;
        font-size: 13px;
        color: #4d4942;
        vertical-align: middle;
        border-bottom: 1px solid #f0ede7;
    }

    .alat-table tbody tr:last-child td {
        border-bottom: none;
    }

    .alat-table tbody tr:hover {
        background: #fdfbf7;
    }

    .alat-table .nomor {
        width: 65px;
        color: #8a8478;
        font-weight: 600;
    }

    .alat-name {
        font-weight: 700;
        color: #29251f;
        min-width: 130px;
    }

    .alat-category {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 7px;
        background: #f4f1ea;
        color: #635c50;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .alat-stock {
        font-weight: 700;
        color: #38332b;
        white-space: nowrap;
    }

    /* Foto alat */
    .alat-photo {
        display: block;
        width: 76px;
        height: 58px;
        object-fit: cover;
        border-radius: 9px;
        border: 1px solid #e9e5dc;
        background: #f6f3ed;
    }

    .alat-no-photo {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 76px;
        height: 58px;
        border-radius: 9px;
        background: #f6f3ed;
        color: #a29b8e;
        font-size: 11px;
    }

    /* Tombol aksi */
    .alat-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .alat-actions form {
        display: inline-flex;
        margin: 0;
    }

    .alat-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        border-radius: 7px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .alat-btn-edit {
        color: #8b5b0d;
        background: #fff5dc;
        border-color: #f4e5bd;
    }

    .alat-btn-edit:hover {
        background: #f8e6b6;
        color: #674205;
    }

    .alat-btn-delete {
        color: #b83232;
        background: #fff0f0;
        border-color: #f4d9d9;
    }

    .alat-btn-delete:hover {
        background: #fce0e0;
        color: #912525;
    }

    /* Kondisi data kosong */
    .alat-empty {
        padding: 45px 20px !important;
        text-align: center;
    }

    .alat-empty-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .alat-empty-title {
        margin: 0 0 6px;
        color: #464138;
        font-size: 14px;
        font-weight: 700;
    }

    .alat-empty-text {
        margin: 0;
        color: #898276;
        font-size: 13px;
    }

    /* Tampilan layar kecil */
    @media (max-width: 768px) {
        .alat-admin-header h1 {
            font-size: 23px;
        }

        .alat-admin-header {
            align-items: flex-start;
        }

        .alat-btn-add {
            padding: 10px 13px;
            font-size: 13px;
        }

        .alat-panel-header {
            padding: 16px;
        }

        .alat-table th,
        .alat-table td {
            padding: 13px 15px;
        }
    }
</style>

<div class="alat-admin-page">

    {{-- Header halaman --}}
    <div class="alat-admin-header">
        <div>
            <div class="alat-admin-eyebrow">
                Inventaris
            </div>

            <h1>Daftar Alat</h1>

            <p class="alat-admin-description">
                Kelola data alat dan stok inventaris laboratorium komputer.
            </p>
        </div>

        <div>
            <a href="{{ route('admin.alat.create') }}" class="alat-btn-add">
                <span>+</span>
                Tambah Alat
            </a>
        </div>
    </div>

    {{-- Tabel data alat --}}
    <div class="alat-panel">

        <div class="alat-panel-header">
            <div>
                <h2 class="alat-panel-title">Data Inventaris Alat</h2>

                <p class="alat-panel-subtitle">
                    Daftar alat yang tersimpan di dalam sistem.
                </p>
            </div>

            <span class="alat-count">
                {{ count($alat ?? []) }} data
            </span>
        </div>

        <div class="alat-table-wrapper">
            <table class="alat-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($alat ?? [] as $item)
                        <tr>
                            <td class="nomor">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="alat-name">
                                    {{ $item->nama_alat }}
                                </div>
                            </td>

                            <td>
                                <span class="alat-category">
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="alat-stock">
                                    {{ $item->jumlah }} unit
                                </span>
                            </td>

                            <td>
                                @if ($item->foto)
                                    <img
                                        src="{{ asset('storage/' . $item->foto) }}"
                                        alt="Foto {{ $item->nama_alat }}"
                                        class="alat-photo"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="alat-no-photo">
                                        Tidak ada foto
                                    </div>
                                @endif
                            </td>

                            <td>
                                <div class="alat-actions">

                                    <a
                                        href="{{ route('admin.alat.edit', $item->id) }}"
                                        class="alat-action-btn alat-btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.alat.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus alat ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="alat-action-btn alat-btn-delete"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="alat-empty">
                                <div class="alat-empty-icon">🧰</div>

                                <p class="alat-empty-title">
                                    Belum Ada Data Alat
                                </p>

                                <p class="alat-empty-text">
                                    Silakan tambahkan data alat untuk mengisi inventaris.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection
