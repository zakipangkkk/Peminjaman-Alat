
@extends('layouts.master')

@section('title', 'Data Kategori')

@section('content')

<style>
    .kategori-admin-page {
        width: 100%;
        padding: 8px 0 24px;
        color: #24211d;
    }

    .kategori-admin-page * {
        box-sizing: border-box;
    }

    /* Header halaman */
    .kategori-admin-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .kategori-eyebrow {
        color: #b47713;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 7px;
    }

    .kategori-admin-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 750;
        line-height: 1.3;
        color: #24211d;
    }

    .kategori-description {
        margin: 8px 0 0;
        font-size: 14px;
        line-height: 1.6;
        color: #817b71;
    }

    /* Tombol tambah */
    .kategori-btn-add {
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

    .kategori-btn-add:hover {
        background: #d99217;
        color: #181410;
        transform: translateY(-1px);
    }

    /* Panel tabel */
    .kategori-panel {
        background: #ffffff;
        border: 1px solid #e9e5dc;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(35, 29, 19, 0.04);
    }

    .kategori-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 20px 24px;
        border-bottom: 1px solid #eeeae2;
        flex-wrap: wrap;
    }

    .kategori-panel-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #29251f;
    }

    .kategori-panel-subtitle {
        margin: 5px 0 0;
        font-size: 13px;
        color: #8a8478;
    }

    .kategori-count {
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

    /* Tabel kategori */
    .kategori-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .kategori-table {
        width: 100%;
        min-width: 500px;
        margin: 0;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .kategori-table thead {
        background: #faf8f3;
    }

    .kategori-table th {
        padding: 15px 24px;
        text-align: left;
        font-size: 11px;
        font-weight: 750;
        color: #797265;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        white-space: nowrap;
        border-bottom: 1px solid #eeeae2;
    }

    .kategori-table td {
        padding: 17px 24px;
        font-size: 13px;
        color: #4d4942;
        vertical-align: middle;
        border-bottom: 1px solid #f0ede7;
    }

    .kategori-table tbody tr:last-child td {
        border-bottom: none;
    }

    .kategori-table tbody tr:hover {
        background: #fdfbf7;
    }

    .kategori-number {
        width: 80px;
        color: #8a8478 !important;
        font-weight: 600;
    }

    .kategori-name {
        font-weight: 700;
        color: #29251f;
    }

    .kategori-name-label {
        display: inline-block;
        padding: 7px 11px;
        border-radius: 7px;
        background: #f4f1ea;
        color: #635c50;
        font-size: 12px;
        font-weight: 600;
    }

    /* Tombol aksi */
    .kategori-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .kategori-actions form {
        display: inline-flex;
        margin: 0;
    }

    .kategori-action-btn {
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

    .kategori-btn-edit {
        color: #8b5b0d;
        background: #fff5dc;
        border-color: #f4e5bd;
    }

    .kategori-btn-edit:hover {
        background: #f8e6b6;
        color: #674205;
    }

    .kategori-btn-delete {
        color: #b83232;
        background: #fff0f0;
        border-color: #f4d9d9;
    }

    .kategori-btn-delete:hover {
        background: #fce0e0;
        color: #912525;
    }

    /* Data kosong */
    .kategori-empty {
        padding: 45px 20px !important;
        text-align: center;
    }

    .kategori-empty-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .kategori-empty-title {
        margin: 0 0 6px;
        color: #464138;
        font-size: 14px;
        font-weight: 700;
    }

    .kategori-empty-text {
        margin: 0;
        color: #898276;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .kategori-admin-header h1 {
            font-size: 23px;
        }

        .kategori-btn-add {
            padding: 10px 13px;
            font-size: 13px;
        }

        .kategori-panel-header {
            padding: 16px;
        }

        .kategori-table th,
        .kategori-table td {
            padding: 13px 15px;
        }
    }
</style>

<div class="kategori-admin-page">

    {{-- Header halaman --}}
    <div class="kategori-admin-header">
        <div>
            <div class="kategori-eyebrow">
                Inventaris
            </div>

            <h1>Daftar Kategori</h1>

            <p class="kategori-description">
                Kelola kategori untuk mengelompokkan alat laboratorium komputer.
            </p>
        </div>

        <div>
            <a href="{{ route('admin.kategori.create') }}"
               class="kategori-btn-add">
                <span>+</span>
                Tambah Kategori
            </a>
        </div>
    </div>

    {{-- Panel kategori --}}
    <div class="kategori-panel">

        <div class="kategori-panel-header">
            <div>
                <h2 class="kategori-panel-title">
                    Data Kategori
                </h2>

                <p class="kategori-panel-subtitle">
                    Daftar kategori inventaris yang terdaftar di sistem.
                </p>
            </div>

            <span class="kategori-count">
                {{ count($kategori ?? []) }} data
            </span>
        </div>

        <div class="kategori-table-wrapper">
            <table class="kategori-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($kategori ?? [] as $item)
                        <tr>
                            <td class="kategori-number">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <span class="kategori-name-label">
                                    {{ $item->nama_kategori }}
                                </span>
                            </td>

                            <td>
                                <div class="kategori-actions">

                                    <a href="{{ route('admin.kategori.edit', $item->id) }}"
                                       class="kategori-action-btn kategori-btn-edit">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.kategori.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="kategori-action-btn kategori-btn-delete">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="3" class="kategori-empty">
                                <div class="kategori-empty-icon">🗂️</div>

                                <p class="kategori-empty-title">
                                    Belum Ada Data Kategori
                                </p>

                                <p class="kategori-empty-text">
                                    Silakan tambahkan kategori untuk mengelompokkan alat.
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
