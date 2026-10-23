@extends('layouts.master')

@section('title', 'RODA - Data Pengembalian')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/admin-crud.css') }}">
@endpush

@section('content')

<main class="crud">

    <p class="eyebrow-plate">PANEL ADMIN · PEMINJAMAN ALAT</p>

    <div class="crud-head">
        <h1 class="page-title">Data pengembalian</h1>
        <a href="{{ route('admin.pengembalian.create') }}" class="btn-amber">+ Tambah pengembalian</a>
    </div>
    <p class="page-sub">Kelola data alat yang sudah dikembalikan.</p>

    @include('admin._alerts')

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr><th>#</th><th>Peminjam</th><th>Alat</th><th>Dikembalikan</th><th>Status</th><th>Denda</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse ($pengembalian as $p)
                    @php $b = $p->booking; $telat = $p->status === 'terlambat'; @endphp
                    <tr>
                        <td data-label="#">{{ $p->id }}</td>
                        <td data-label="Peminjam">
                            <strong>{{ optional(optional($b)->user)->name ?? 'User dihapus' }}</strong>
                            <span class="sub">Peminjaman #{{ optional($b)->id }}</span>
                        </td>
                        <td data-label="Alat">
                            <ul class="item-list">
                                @foreach (optional($b)->detail ?? [] as $d)
                                    <li>{{ optional($d->alat)->nama_alat ?? 'Alat dihapus' }} <b>× {{ $d->jumlah }}</b></li>
                                @endforeach
                            </ul>
                        </td>
                        <td data-label="Dikembalikan">
                            {{ $p->tanggal_kembali->translatedFormat('d M Y') }}
                            @if ($p->keterangan && $p->keterangan !== '-')<span class="sub">{{ $p->keterangan }}</span>@endif
                        </td>
                        <td data-label="Status">
                            <span class="stamp {{ $telat ? 'stamp-rejected' : 'stamp-approved' }}">{{ $telat ? 'Terlambat' : 'Tepat waktu' }}</span>
                        </td>
                        <td data-label="Denda">
                            {{ $p->denda > 0 ? 'Rp ' . number_format($p->denda, 0, ',', '.') : '—' }}
                        </td>
                        <td data-label="Aksi">
                            <div class="actions">
                                <a href="{{ route('admin.pengembalian.edit', $p->id) }}" class="btn-act">Edit</a>

                                <form action="{{ route('admin.pengembalian.destroy', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus data pengembalian #{{ $p->id }}? Peminjamannya akan kembali berstatus disetujui dan stok alat dikurangi lagi.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-no">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-row">
                            <strong>Belum ada data pengembalian</strong>
                            Klik "Tambah pengembalian" untuk mencatat alat yang kembali.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pager">
        @if ($pengembalian->previousPageUrl())<a href="{{ $pengembalian->previousPageUrl() }}" class="chip">← Sebelumnya</a>@endif
        @if ($pengembalian->nextPageUrl())<a href="{{ $pengembalian->nextPageUrl() }}" class="chip">Berikutnya →</a>@endif
    </div>

</main>

@endsection