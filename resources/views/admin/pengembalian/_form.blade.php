@php $edit = isset($pengembalian); @endphp

<form action="{{ $edit ? route('admin.pengembalian.update', $pengembalian->id) : route('admin.pengembalian.store') }}"
      method="POST" class="crud-form" novalidate>
    @csrf
    @if ($edit) @method('PUT') @endif

    {{-- PEMINJAMAN --}}
    <div class="field">
        <label for="booking_id">Peminjaman</label>

        @if ($edit)
            @php $b = $pengembalian->booking; @endphp
            <p class="static">
                #{{ optional($b)->id }} · {{ optional(optional($b)->user)->name ?? 'User dihapus' }}
                <span class="sub">
                    @foreach (optional($b)->detail ?? [] as $d)
                        {{ optional($d->alat)->nama_alat ?? 'Alat dihapus' }} × {{ $d->jumlah }}@if (!$loop->last), @endif
                    @endforeach
                    · jatuh tempo {{ optional($b)->tanggal_selesai?->translatedFormat('d M Y') }}
                </span>
            </p>
        @else
            <select id="booking_id" name="booking_id" required>
                <option value="">— pilih peminjaman yang sedang berjalan —</option>
                @foreach ($bookings as $b)
                    <option value="{{ $b->id }}" @selected((string) old('booking_id') === (string) $b->id)>
                        #{{ $b->id }} · {{ optional($b->user)->name }} ·
                        {{ $b->detail->map(fn ($d) => (optional($d->alat)->nama_alat ?? '?') . ' ×' . $d->jumlah)->implode(', ') }}
                        (jatuh tempo {{ $b->tanggal_selesai->format('d/m/Y') }})
                    </option>
                @endforeach
            </select>

            @if ($bookings->isEmpty())
                <p class="form-note">Tidak ada peminjaman yang sedang berjalan. Peminjaman harus disetujui petugas lebih dulu.</p>
            @endif
        @endif
    </div>

    <div class="field-row">
        <div class="field">
            <label for="tanggal_kembali">Tanggal kembali</label>
            <input type="date" id="tanggal_kembali" name="tanggal_kembali" required
                   value="{{ old('tanggal_kembali', $edit ? $pengembalian->tanggal_kembali->format('Y-m-d') : date('Y-m-d')) }}">
        </div>
        <div class="field">
            <label for="denda">Denda (Rp)</label>
            <input type="number" id="denda" name="denda" min="0" step="1000"
                   value="{{ old('denda', $edit ? (int) $pengembalian->denda : 0) }}">
        </div>
    </div>

    <div class="field">
        <label for="keterangan">Keterangan (opsional)</label>
        <textarea id="keterangan" name="keterangan" rows="3" maxlength="255"
                  placeholder="Contoh: kondisi alat baik">{{ old('keterangan', $edit && $pengembalian->keterangan !== '-' ? $pengembalian->keterangan : '') }}</textarea>
    </div>

    <p class="form-note">Status (tepat waktu atau terlambat) dihitung otomatis dari tanggal kembali dan jatuh tempo.</p>

    <div class="form-actions">
        <button type="submit" class="btn-amber">{{ $edit ? 'Simpan perubahan' : 'Simpan' }}</button>
        <a href="{{ route('admin.pengembalian.index') }}" class="btn-ghost">Batal</a>
    </div>
</form>