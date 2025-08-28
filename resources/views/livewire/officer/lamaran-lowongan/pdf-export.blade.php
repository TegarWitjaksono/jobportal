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
    <div class="header">
        <h1>Daftar Lamaran Lowongan</h1>
        <p>Laporan diekspor pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>
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
                    <td>{{ optional($lamaran->created_at)->translatedFormat('d F Y, H:i') }}</td>
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

