<table>
    <thead>
        <tr>
            <th>Nama Posisi</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Tanggal Posting</th>
            <th>Tanggal Berakhir</th>
        </tr>
    </thead>
    <tbody>
    @foreach($lowongans as $lowongan)
        <tr>
            <td>{{ $lowongan->nama_posisi }}</td>
            <td>{{ optional($lowongan->kategoriLowongan)->nama_kategori }}</td>
            <td>{{ ucfirst($lowongan->status) }}</td>
            <td>{{ optional($lowongan->tanggal_posting)->format('Y-m-d') }}</td>
            <td>{{ optional($lowongan->tanggal_berakhir)->format('Y-m-d') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
