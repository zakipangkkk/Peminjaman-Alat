<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan {{ ucfirst($jenis) }} Alat</title>
    <style>
        @page { size: A4 landscape; margin: 16mm; }
        * { box-sizing: border-box; }
        body { font-family: 'Work Sans', Arial, sans-serif; color: #000; font-size: 12px; line-height: 1.45; margin: 0; padding: 20px; background: #fff; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 16px; }
        .kop h1 { margin: 0; font-size: 20px; letter-spacing: .05em; text-transform: uppercase; }
        .kop p { margin: 2px 0 0; }
        .meta { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 8px; margin-bottom: 12px; }
        .ringkasan { display: flex; flex-wrap: wrap; gap: 6px 26px; margin-bottom: 14px; padding: 8px 10px; border: 1px solid #000; }
        .ringkasan b { font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; vertical-align: top; }
        th { background: #e6e6e6; text-transform: uppercase; font-size: 11px; letter-spacing: .05em; }
        tr { page-break-inside: avoid; }
        .ttd { margin-top: 36px; display: flex; justify-content: flex-end; }
        .ttd div { width: 220px; text-align: center; }
        .ttd .garis { margin-top: 64px; border-top: 1px solid #000; padding-top: 4px; font-weight: 600; }
        .tombol { margin-bottom: 16px; }
        .tombol button { padding: 8px 18px; font-size: 14px; cursor: pointer; }
        @media print { .tombol { display: none; } body { padding: 0; } }
    </style>
</head>
<body>

    <div class="tombol">
        <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
        <button type="button" onclick="window.close()">Tutup</button>
    </div>

    <div class="kop">
        <h1>Laporan {{ $jenis === 'pengembalian' ? 'Pengembalian' : 'Peminjaman' }} Alat</h1>
        <p>RODA · Peminjaman Alat Cimahi &amp; Sekitarnya</p>
    </div>

    <div class="meta">
        <div>
            Periode:
            <b>{{ \Carbon\Carbon::parse($dari)->translatedFormat('d F Y') }}</b> s/d
            <b>{{ \Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }}</b>
            @if ($status)
                · Status: <b>{{ ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'completed' => 'Selesai'][$status] ?? $status }}</b>
            @endif
        </div>
        <div>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</div>
    </div>

    <div class="ringkasan">
        @foreach ($ringkasan as [$label, $nilai])
            <div>{{ $label }}: <b>{{ $nilai }}</b></div>
        @endforeach
    </div>

    @include('petugas.laporan._tabel')

    <div class="ttd">
        <div>
            Cimahi, {{ now()->translatedFormat('d F Y') }}<br>
            Petugas,
            <div class="garis">{{ auth()->user()->name }}</div>
        </div>
    </div>

    <script>window.addEventListener('load', () => setTimeout(() => window.print(), 400));</script>

</body>
</html>