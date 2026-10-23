
@extends('layouts.master')

@section('title', 'Data Pengguna')

@section('content')

<style>
    .user-admin-page {
        width: 100%;
        padding: 8px 0 24px;
        color: #24211d;
    }

    .user-admin-page * {
        box-sizing: border-box;
    }

    /* Header */
    .user-admin-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .user-eyebrow {
        color: #b47713;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 7px;
    }

    .user-admin-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 750;
        line-height: 1.3;
        color: #24211d;
    }

    .user-description {
        margin: 8px 0 0;
        font-size: 14px;
        line-height: 1.6;
        color: #817b71;
    }

    /* Tombol tambah */
    .user-btn-add {
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

    .user-btn-add:hover {
        background: #d99217;
        color: #181410;
        transform: translateY(-1px);
    }

    /* Panel */
    .user-panel {
        background: #fff;
        border: 1px solid #e9e5dc;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(35, 29, 19, 0.04);
    }

    .user-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 20px 24px;
        border-bottom: 1px solid #eeeae2;
        flex-wrap: wrap;
    }

    .user-panel-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #29251f;
    }

    .user-panel-subtitle {
        margin: 5px 0 0;
        font-size: 13px;
        color: #8a8478;
    }

    .user-count {
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

    /* Tabel */
    .user-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .user-table {
        width: 100%;
        min-width: 1000px;
        margin: 0;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .user-table thead {
        background: #faf8f3;
    }

    .user-table th {
        padding: 15px 18px;
        text-align: left;
        font-size: 11px;
        font-weight: 750;
        color: #797265;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        white-space: nowrap;
        border-bottom: 1px solid #eeeae2;
    }

    .user-table td {
        padding: 16px 18px;
        font-size: 13px;
        color: #4d4942;
        vertical-align: middle;
        border-bottom: 1px solid #f0ede7;
    }

    .user-table tbody tr:last-child td {
        border-bottom: none;
    }

    .user-table tbody tr:hover {
        background: #fdfbf7;
    }

    .user-name {
        font-weight: 700;
        color: #29251f;
        white-space: nowrap;
    }

    .user-email {
        color: #6f695e;
    }

    .user-phone {
        white-space: nowrap;
    }

    /* Label role */
    .user-role {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .user-role-admin {
        background: #fff0ed;
        color: #b83b2b;
    }

    .user-role-petugas {
        background: #eaf2ff;
        color: #315c9c;
    }

    .user-role-user {
        background: #fbf3df;
        color: #94610f;
    }

    .user-role-default {
        background: #f1efea;
        color: #625c52;
    }

    .user-total {
        font-weight: 700;
        color: #39342c;
        white-space: nowrap;
    }

    .user-date {
        white-space: nowrap;
        color: #6f695e;
    }

    /* Tombol aksi */
    .user-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .user-actions form {
        display: inline-flex;
        margin: 0;
    }

    .user-action-btn {
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

    .user-btn-edit {
        color: #8b5b0d;
        background: #fff5dc;
        border-color: #f4e5bd;
    }

    .user-btn-edit:hover {
        background: #f8e6b6;
        color: #674205;
    }

    .user-btn-delete {
        color: #b83232;
        background: #fff0f0;
        border-color: #f4d9d9;
    }

    .user-btn-delete:hover {
        background: #fce0e0;
        color: #912525;
    }

    /* Data kosong */
    .user-empty {
        padding: 45px 20px !important;
        text-align: center;
    }

    .user-empty-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .user-empty-title {
        margin: 0 0 6px;
        color: #464138;
        font-size: 14px;
        font-weight: 700;
    }

    .user-empty-text {
        margin: 0;
        color: #898276;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .user-admin-header h1 {
            font-size: 23px;
        }

        .user-btn-add {
            padding: 10px 13px;
            font-size: 13px;
        }

        .user-panel-header {
            padding: 16px;
        }

        .user-table th,
        .user-table td {
            padding: 13px 15px;
        }
    }
</style>

<div class="user-admin-page">

    {{-- Header halaman --}}
    <div class="user-admin-header">
        <div>
            <div class="user-eyebrow">
                Manajemen Pengguna
            </div>

            <h1>Data Pengguna</h1>

            <p class="user-description">
                Kelola akun pengguna, admin, dan petugas sistem peminjaman alat.
            </p>
        </div>

        <div>
            <a href="{{ route('admin.user.create') }}"
               class="user-btn-add">
                <span>+</span>
                Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- Panel tabel --}}
    <div class="user-panel">

        <div class="user-panel-header">
            <div>
                <h2 class="user-panel-title">
                    Daftar Pengguna
                </h2>

                <p class="user-panel-subtitle">
                    Informasi akun dan aktivitas peminjaman pengguna.
                </p>
            </div>

            <span class="user-count">
                {{ count($pelanggan ?? []) }} data
            </span>
        </div>

        <div class="user-table-wrapper">
            <table class="user-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Role</th>
                        <th>Total Peminjaman</th>
                        <th>Terakhir Diperbarui</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pelanggan ?? [] as $item)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="user-name">
                                    {{ $item->username }}
                                </div>
                            </td>

                            <td>
                                <span class="user-email">
                                    {{ $item->email }}
                                </span>
                            </td>

                            <td>
                                <span class="user-phone">
                                    {{ $item->no_telfon ?: '-' }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $roleClass = match ($item->role) {
                                        'admin' => 'user-role-admin',
                                        'petugas' => 'user-role-petugas',
                                        'user' => 'user-role-user',
                                        default => 'user-role-default',
                                    };
                                @endphp

                                <span class="user-role {{ $roleClass }}">
                                    {{ $item->role }}
                                </span>
                            </td>

                            <td>
                                <span class="user-total">
                                    {{ $item->booking ?? $item->booking ?? 0 }}
                                    kali
                                </span>
                            </td>

                            <td>
                                <span class="user-date">
                                    {{ $item->updated_at?->format('d M Y') ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="user-actions">

                                    <a href="{{ route('admin.user.edit', $item->id) }}"
                                       class="user-action-btn user-btn-edit">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.user.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="user-action-btn user-btn-delete">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="user-empty">
                                <div class="user-empty-icon">👥</div>

                                <p class="user-empty-title">
                                    Belum Ada Data Pengguna
                                </p>

                                <p class="user-empty-text">
                                    Data pengguna yang terdaftar akan ditampilkan di sini.
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
