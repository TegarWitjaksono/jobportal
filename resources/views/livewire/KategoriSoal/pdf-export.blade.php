<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kategori Soal</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 11px; color:#111827; }
        h2 { margin: 0 0 8px 0; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        th { background: #f3f4f6; text-align: left; }
    </style>
</head>
<body>
    <h2>Daftar Kategori Soal</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $i => $k)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $k->nama_kategori }}</td>
                <td>{{ \Illuminate\Support\Str::limit($k->deskripsi, 120) }}</td>
                <td>{{ $k->status ? 'Aktif' : 'Nonaktif' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

