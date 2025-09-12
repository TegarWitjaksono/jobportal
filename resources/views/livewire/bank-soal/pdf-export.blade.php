<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bank Soal</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 11px; color:#111827; }
        h2 { margin: 0 0 8px 0; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        th { background: #f3f4f6; text-align: left; }
    </style>
</head>
<body>
    <h2>Daftar Bank Soal</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Soal</th>
                <th>Kategori</th>
                <th>Jawaban Benar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soals as $i => $s)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>
                    @if($s->type_soal === 'foto')
                        [Gambar]
                    @else
                        {{ \Illuminate\Support\Str::limit($s->soal, 90) }}
                    @endif
                </td>
                <td>{{ optional($s->kategori)->nama_kategori }}</td>
                <td>{{ $s['pilihan_'.($s->jawaban ?? '1')] ?? '-' }}</td>
                <td>{{ $s->status ? 'Aktif' : 'Nonaktif' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

