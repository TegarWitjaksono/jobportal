<table>
    <thead>
        <tr>
            <th>Nama Kandidat</th>
            <th>Nilai</th>
            <th>Status</th>
            <th>Jawaban Benar</th>
            <th>Total Soal</th>
            <th>Waktu Mulai</th>
            <th>Selesai</th>
        </tr>
    </thead>
    <tbody>
    @foreach($results as $result)
        <tr>
            <td>{{ $result->user->name }}</td>
            <td>{{ $result->score }}</td>
            <td>{{ $result->score >= 70 ? 'Lulus' : 'Tidak Lulus' }}</td>
            <td>{{ $result->correct_answers }}</td>
            <td>{{ $result->total_questions }}</td>
            <td>{{ optional($result->started_at)->format('Y-m-d H:i') }}</td>
            <td>{{ optional($result->completed_at)->format('Y-m-d H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
