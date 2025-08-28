<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Interview</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; }
        .header p { margin: 5px 0; font-size: 13px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .small { font-size: 11px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Jadwal Interview</h1>
        <p>Diekspor pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:50px;" class="text-center">No.</th>
                <th>Kandidat</th>
                <th>Posisi</th>
                <th style="width:160px;">Waktu</th>
                <th>Link Zoom</th>
            </tr>
        </thead>
        <tbody>
            @forelse($interviews as $index => $progress)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        {{ optional(optional($progress->lamarlowongan)->kandidat->user)->name ?? '-' }}
                    </td>
                    <td>{{ optional(optional($progress->lamarlowongan)->lowongan)->nama_posisi ?? '-' }}</td>
                    <td>{{ optional($progress->waktu_pelaksanaan)->translatedFormat('d F Y, H:i') }}</td>
                    <td>
                        @if($progress->link_zoom)
                            {{ $progress->link_zoom }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada jadwal interview sesuai filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

