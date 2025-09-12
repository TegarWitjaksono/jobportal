<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Officer</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 11px; color:#111827; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        th { background: #f3f4f6; text-align: left; }
        .small { color:#6b7280; font-size:10px; }
        .letterhead{ display:flex; align-items:center; gap:12px; padding-bottom:8px; border-bottom:2px solid #e5e7eb; margin-bottom:14px; }
        .lh-left img{ max-height:42px; }
        .lh-right .company{ font-size:16px; font-weight:700; line-height:1.2; color:#111827; }
        .lh-right .tagline{ font-size:12px; font-weight:600; color:#1f2937; }
        .lh-right .address{ font-size:11px; color:#6b7280; }
        .header { text-align:center; margin-bottom: 16px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 4px 0 0; font-size: 12px; color: #6b7280; }
    </style>
    <!-- Remote image allowed by Dompdf options set by caller -->
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
        <h1>Daftar Officer</h1>
        <p>Laporan diekspor pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Jabatan</th>
                <th>DOH</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($officers as $i => $o)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ trim(($o->nama_depan ?? '') . ' ' . ($o->nama_belakang ?? '')) ?: '-' }}</td>
                <td>{{ $o->nik ?? '-' }}</td>
                <td>{{ $o->jabatan ?? '-' }}</td>
                <td>{{ $o->doh ? \Carbon\Carbon::parse($o->doh)->format('d M Y') : '-' }}</td>
                <td>{{ $o->lokasi_penugasan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
