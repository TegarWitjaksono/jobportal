<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kategori Lowongan</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
        .logo-img {
            max-width: 50px;
            max-height: 50px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daftar Kategori Lowongan</h1>
        <p>Laporan dibuat pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 80px;">Logo</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoriLowongans as $kategori)
            <tr>
                <td class="text-center">
                    @php
                        // Cek apakah file logo ada di storage
                        $logoPath = public_path('storage/image/logo/kategori-lowongan/' . $kategori->logo);
                    @endphp
                    @if($kategori->logo && file_exists($logoPath))
                        @php
                            // Konversi gambar ke base64 agar bisa di-embed di PDF
                            $imageData = base64_encode(file_get_contents($logoPath));
                            $imageType = pathinfo($logoPath, PATHINFO_EXTENSION);
                            $src = 'data:image/' . $imageType . ';base64,' . $imageData;
                        @endphp
                        <img src="{{ $src }}" alt="Logo" class="logo-img">
                    @else
                        <span>-</span>
                    @endif
                </td>
                <td>{{ $kategori->nama_kategori }}</td>
                <td>{{ $kategori->deskripsi }}</td> {{-- Menampilkan deskripsi lengkap --}}
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Tidak ada data kategori.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>