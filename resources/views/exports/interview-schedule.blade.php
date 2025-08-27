<table>
    <thead>
        <tr>
            <th>Kandidat</th>
            <th>Posisi</th>
            <th>Waktu Pelaksanaan</th>
            <th>Link Zoom</th>
        </tr>
    </thead>
    <tbody>
    @foreach($interviews as $interview)
        <tr>
            <td>{{ optional($interview->lamarlowongan->kandidat->user)->name }}</td>
            <td>{{ optional($interview->lamarlowongan->lowongan)->nama_posisi }}</td>
            <td>{{ optional($interview->waktu_pelaksanaan)->format('Y-m-d H:i') }}</td>
            <td>{{ $interview->link_zoom }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
