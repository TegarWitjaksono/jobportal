<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Lowongan</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 11px; color:#111827; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        th { background: #f3f4f6; text-align: left; }
        .letterhead{ display:flex; align-items:center; gap:12px; padding-bottom:8px; border-bottom:2px solid #e5e7eb; margin-bottom:14px; }
        .lh-left img{ max-height:42px; }
        .lh-right .company{ font-size:16px; font-weight:700; line-height:1.2; color:#111827; }
        .lh-right .tagline{ font-size:12px; font-weight:600; color:#1f2937; }
        .lh-right .address{ font-size:11px; color:#6b7280; }
        .header { text-align:center; margin-bottom: 16px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 4px 0 0; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    @php
        $logoUrl = 'https://toploker.com/assets/images/perusahaan/profile/multindo.jpg';
    @endphp
    <div class="letterhead">
        <div class="lh-left">
            <img src="{{ $logoUrl }}" alt="Logo">
        </div>
        <div class="lh-right">
            <div class="company">PT. Multindo Technology Utama</div>
            <div class="tagline">Mining &amp; Industrial Service</div>
            <div class="address">Jl. Raya Mustikasari No.124, RT.001/RW.4, Padurenan, Kec. Mustika Jaya, Kota Bks, Jawa Barat 16340</div>
        </div>
    </div>
    <div class="header">
        <h1>Daftar Lowongan</h1>
        <p>Laporan diekspor pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Posisi</th>
                <th>Departemen</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Tgl Posting</th>
                <th>Tgl Berakhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowongans as $i => $l)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $l->nama_posisi }}</td>
                <td>{{ $l->departemen }}</td>
                <td>{{ optional($l->kategoriLowongan)->nama_kategori }}</td>
                <td>{{ $l->lokasi_penugasan }}</td>
                <td>{{ ucfirst($l->status) }}</td>
                <td>{{ $l->tanggal_posting ? \Carbon\Carbon::parse($l->tanggal_posting)->format('d M Y') : '-' }}</td>
                <td>{{ $l->tanggal_berakhir ? \Carbon\Carbon::parse($l->tanggal_berakhir)->format('d M Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
