<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kandidat</title>
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
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
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
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daftar Kandidat</h1>
        <p>Laporan diekspor pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Lengkap</th>
                <th>No. Telepon</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kandidats as $index => $kandidat)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $kandidat->getFullNameAttribute() }}</td>
                <td>{{ $kandidat->no_telpon }}</td>
                <td>{{ $kandidat->user->email }}</td>
                <td><span class="badge bg-soft-success">Aktif</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data kandidat yang cocok dengan filter saat ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>