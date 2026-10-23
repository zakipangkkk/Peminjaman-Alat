@php
    $edit   = isset($booking);
    $locked = $edit && $booking->status !== 'pending';

    $rows = old('items', $edit
        ? $booking->detail->map(fn ($d) => ['alat_id' => $d->alat_id, 'jumlah' => $d->jumlah])->all()
        : [['alat_id' => '', 'jumlah' => 1]]);

    $label = ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'completed' => 'Selesai'];
@endphp

<form action="{{ $edit ? route('admin.booking.update', $booking->id) : route('admin.booking.store') }}"
      method="POST" class="crud-form" novalidate>
    @csrf
    @if ($edit) @method('PUT') @endif

    @if ($locked)
        <div class="alert alert-info">
            Peminjaman ini sudah diproses petugas (<b>{{ $label[$booking->status] ?? $booking->status }}</b>).
            Hanya tanggal yang bisa diubah.
        </div>
    @endif

    {{-- PEMINJAM --}}
    <div class="field">
        <label for="user_id">Peminjam</label>
        @if ($locked)
            <p class="static">{{ optional($booking->user)->name ?? 'User dihapus' }}</p>
        @else
            <select id="user_id" name="user_id" required>
                <option value="">— pilih peminjam —</option>
                @foreach ($users as $u)
                    <option value="{{ $u->id }}" @selected((string) old('user_id', $edit ? $booking->user_id : '') === (string) $u->id)>
                        {{ $u->username }}
                    </option>
                @endforeach
            </select>
        @endif
    </div>

    {{-- TANGGAL --}}
    <div class="field-row">
        <div class="field">
            <label for="tanggal_mulai">Tanggal mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                   value="{{ old('tanggal_mulai', $edit ? $booking->tanggal_mulai->format('Y-m-d') : '') }}">
        </div>
        <div class="field">
            <label for="tanggal_selesai">Tanggal selesai</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                   value="{{ old('tanggal_selesai', $edit ? $booking->tanggal_selesai->format('Y-m-d') : '') }}">
        </div>
    </div>

    {{-- ALAT --}}
    <div class="field">
        <label>Alat yang dipinjam</label>

        @if ($locked)
            <ul class="item-list">
                @foreach ($booking->detail as $d)
                    <li>{{ optional($d->alat)->nama_alat ?? 'Alat dihapus' }} <b>× {{ $d->jumlah }}</b></li>
                @endforeach
            </ul>
        @else
            <div id="rows">
                @foreach ($rows as $i => $row)
                    <div class="item-row">
                        <select name="items[{{ $i }}][alat_id]" aria-label="Alat" required>
                            <option value="">— pilih alat —</option>
                            @foreach ($alats as $a)
                                <option value="{{ $a->id }}" @selected((string) ($row['alat_id'] ?? '') === (string) $a->id)>
                                    {{ $a->nama_alat }} (stok {{ $a->jumlah }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="items[{{ $i }}][jumlah]" min="1" value="{{ $row['jumlah'] ?? 1 }}" aria-label="Jumlah" required>
                        <button type="button" class="btn-act btn-no" onclick="this.parentElement.remove()">Hapus</button>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn-act" id="addRow">+ Tambah alat</button>

            <template id="rowTpl">
                <div class="item-row">
                    <select name="items[__i__][alat_id]" aria-label="Alat" required>
                        <option value="">— pilih alat —</option>
                        @foreach ($alats as $a)
                            <option value="{{ $a->id }}">{{ $a->nama_alat }} (stok {{ $a->jumlah }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="items[__i__][jumlah]" min="1" value="1" aria-label="Jumlah" required>
                    <button type="button" class="btn-act btn-no" onclick="this.parentElement.remove()">Hapus</button>
                </div>
            </template>
        @endif
    </div>

    @unless ($edit)
        <p class="form-note">Data baru otomatis berstatus <b>menunggu</b> sampai diverifikasi petugas.</p>
    @endunless

    <div class="form-actions">
        <button type="submit" class="btn-amber">{{ $edit ? 'Simpan perubahan' : 'Simpan' }}</button>
        <a href="{{ route('admin.booking.index') }}" class="btn-ghost">Batal</a>
    </div>

</form>

@unless ($locked)
<script>
    let nextIndex = {{ count($rows) }};
    document.getElementById('addRow').addEventListener('click', () => {
        const html = document.getElementById('rowTpl').innerHTML.replaceAll('__i__', nextIndex++);
        document.getElementById('rows').insertAdjacentHTML('beforeend', html);
    });
</script>
@endunless