@php
    $labelStatus = ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'completed' => 'Selesai'];
@endphp

<table class="data-table">

    @if ($jenis === 'pengembalian')

        <thead>
            <tr>
                <th>No</th><th>Peminjam</th><th>Alat</th><th>Dipinjam</th><th>Dikembalikan</th><th>Status</th><th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $i => $p)
                @php $b = $p->booking; @endphp
                <tr>
                    <td data-label="No">{{ $i + 1 }}</td>
                    <td data-label="Peminjam">{{ optional(optional($b)->user)->name ?? '-' }}</td>
                    <td data-label="Alat">
                        @foreach (optional($b)->detail ?? [] as $d)
                            {{ optional($d->alat)->nama_alat ?? 'Alat dihapus' }} × {{ $d->jumlah }}<br>
                        @endforeach
                    </td>
                    <td data-label="Dipinjam">
                        @if ($b) {{ $b->tanggal_mulai->format('d/m/Y') }} – {{ $b->tanggal_selesai->format('d/m/Y') }} @endif
                    </td>
                    <td data-label="Dikembalikan">{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                    <td data-label="Status">{{ ucfirst($p->status) }}</td>
                    <td data-label="Denda">Rp {{ number_format($p->denda, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty-row">Tidak ada data pengembalian pada periode ini.</td></tr>
            @endforelse
        </tbody>

    @else

        <thead>
            <tr>
                <th>No</th><th>Peminjam</th><th>Alat</th><th>Tanggal pinjam</th><th>Status</th><th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $i => $b)
                <tr>
                    <td data-label="No">{{ $i + 1 }}</td>
                    <td data-label="Peminjam">{{ optional($b->user)->name ?? '-' }}</td>
                    <td data-label="Alat">
                        @foreach ($b->detail as $d)
                            {{ optional($d->alat)->nama_alat ?? 'Alat dihapus' }} × {{ $d->jumlah }}<br>
                        @endforeach
                    </td>
                    <td data-label="Tanggal pinjam">{{ $b->tanggal_mulai->format('d/m/Y') }} – {{ $b->tanggal_selesai->format('d/m/Y') }}</td>
                    <td data-label="Status">{{ $labelStatus[$b->status] ?? $b->status }}</td>
                    <td data-label="Keterangan">
                        @if ($b->catatan) {{ $b->catatan }} @endif
                        @if ($b->pengembalian)
                            Kembali {{ $b->pengembalian->tanggal_kembali->format('d/m/Y') }} ({{ $b->pengembalian->status }})
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty-row">Tidak ada data peminjaman pada periode ini.</td></tr>
            @endforelse
        </tbody>

    @endif

</table>