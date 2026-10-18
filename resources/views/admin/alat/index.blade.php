@extends('layouts.master')

@section('title', 'Data Alat')

@section('content')

<div class="topbar">

```
<div>
    <div class="eyebrow">
        Inventaris
    </div>

    <h1>
        Daftar Alat
    </h1>
</div>

<div class="topbar-right">

    <a href="{{ route('admin.alat.create') }}" class="btn">
        + Tambah Alat
    </a>

</div>
```

</div>

<div class="panel">

```
<table>

    <thead>

        <tr>
            <th>No</th>
            <th>Alat</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>

    </thead>

    <tbody>

        @forelse($alat ?? [] as $item)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $item->nama_alat }}
            </td>

            <td>
                {{ $item->kategori->nama_kategori ?? '-' }}
            </td>

            <td>
                {{ $item->jumlah }} unit
            </td>

            <td>

                @if ($item->foto)

                    <img src="{{ asset('storage/' . $item->foto) }}"
                         alt="{{ $item->nama_alat }}"
                         style="width: 70px; height: 50px; object-fit: cover;">

                @else

                    -

                @endif

            </td>

            <td class="row-actions">

                <a href="{{ route('admin.alat.edit', $item->id) }}">
                    Edit
                </a>

                <form action="{{ route('admin.alat.destroy', $item->id) }}"
                      method="POST">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            onclick="return confirm('Yakin ingin menghapus alat ini?')">

                        Hapus

                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="6" style="text-align:center;">
                Belum ada data alat.
            </td>
        </tr>

        @endforelse

    </tbody>

</table>
```

</div>

@endsection
