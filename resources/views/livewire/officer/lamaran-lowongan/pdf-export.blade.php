<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lamaran Lowongan</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .letterhead{ display:flex; align-items:center; gap:12px; padding-bottom:8px; border-bottom:2px solid #e5e7eb; margin-bottom:14px; }
        .lh-left img{ max-height:42px; }
        .lh-right .company{ font-size:16px; font-weight:700; line-height:1.2; color:#111827; }
        .lh-right .tagline{ font-size:12px; font-weight:600; color:#1f2937; }
        .lh-right .address{ font-size:11px; color:#6b7280; }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .header p {
            margin: 5px 0;
            font-size: 13px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center { text-align: center; }
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
        <h1>Daftar Lamaran Lowongan</h1>
        <p>Laporan diekspor pada: {{ now()->locale('id')->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:50px;" class="text-center">No.</th>
                <th>Kandidat</th>
                <th>Posisi</th>
                <th style="width:150px;">Tanggal Lamar</th>
                <th style="width:120px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lamarans as $index => $lamaran)
                @php
                    $latest = optional($lamaran->progressRekrutmen)->last();
                    $status = $latest ? $latest->status : 'pending';
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ optional(optional($lamaran->kandidat)->user)->name ?? '-' }}</td>
                    <td>{{ optional($lamaran->lowongan)->nama_posisi ?? '-' }}</td>
                    <td>{{ optional($lamaran->created_at)->locale('id')->translatedFormat('d F Y, H:i') }}</td>
                    <td>{{ ucfirst($status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data lamaran yang cocok dengan filter saat ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
