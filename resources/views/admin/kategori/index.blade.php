@extends('layouts.master')

@section('title', 'Data Kategori')

@section('content')

<div class="topbar">

```
<div>
    <div class="eyebrow">
        Inventaris
    </div>

    <h1>
        Daftar Kategori
    </h1>
</div>

<div class="topbar-right">

    <a href="{{ route('admin.kategori.create') }}" class="btn">
        + Tambah Kategori
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
            <th>nama kategori</th>
        </tr>

    </thead>

    <tbody>

        @forelse($kategori ?? [] as $item)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $item->nama_kategori }}
            </td>

            <td class="row-actions">

                <a href="{{ route('admin.kategori.edit', $item->id) }}">
                    Edit
                </a>

                <form action="{{ route('admin.kategori.destroy', $item->id) }}"
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
