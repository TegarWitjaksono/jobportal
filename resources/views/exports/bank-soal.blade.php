<table>
    <thead>
        <tr>
            <th>Soal</th>
            <th>Kategori</th>
            <th>Pilihan 1</th>
            <th>Pilihan 2</th>
            <th>Pilihan 3</th>
            <th>Pilihan 4</th>
            <th>Jawaban</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach($soals as $soal)
        <tr>
            <td>{{ $soal->soal }}</td>
            <td>{{ $soal->kategori->nama_kategori }}</td>
            <td>{{ $soal->pilihan_1 }}</td>
            <td>{{ $soal->pilihan_2 }}</td>
            <td>{{ $soal->pilihan_3 }}</td>
            <td>{{ $soal->pilihan_4 }}</td>
            <td>{{ $soal->jawaban }}</td>
            <td>{{ $soal->status ? 'Aktif' : 'Nonaktif' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
