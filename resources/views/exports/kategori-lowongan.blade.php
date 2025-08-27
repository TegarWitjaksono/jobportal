<table>
    <thead>
        <tr>
            <th>Nama Kategori</th>
            <th>Deskripsi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach($kategoriLowongans as $kategori)
        <tr>
            <td>{{ $kategori->nama_kategori }}</td>
            <td>{{ $kategori->deskripsi }}</td>
            <td>{{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
