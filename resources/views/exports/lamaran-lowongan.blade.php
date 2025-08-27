<table>
    <thead>
        <tr>
            <th>Kandidat</th>
            <th>Email</th>
            <th>Posisi</th>
            <th>Tanggal Lamar</th>
        </tr>
    </thead>
    <tbody>
    @foreach($lamaranList as $lamaran)
        <tr>
            <td>{{ optional($lamaran->kandidat->user)->name }}</td>
            <td>{{ optional($lamaran->kandidat->user)->email }}</td>
            <td>{{ optional($lamaran->lowongan)->nama_posisi }}</td>
            <td>{{ optional($lamaran->created_at)->format('Y-m-d') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
