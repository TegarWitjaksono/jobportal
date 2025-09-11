<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Review Hasil Psikotes</title>
    <style>
        body{ font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color:#1e293b; font-size:12px; }
        h1{ font-size:20px; margin:0 0 6px; }
        h2{ font-size:16px; margin:14px 0 8px; }
        .muted{ color:#64748b; }
        .letterhead{ display:flex; align-items:center; gap:12px; padding-bottom:8px; border-bottom:2px solid #e5e7eb; margin-bottom:14px; }
        .lh-left img{ max-height:42px; }
        .lh-right .company{ font-size:16px; font-weight:700; line-height:1.2; color:#111827; }
        .lh-right .tagline{ font-size:12px; font-weight:600; color:#1f2937; }
        .lh-right .address{ font-size:11px; color:#6b7280; }
        .grid{ display:grid; grid-template-columns: repeat(3,1fr); gap:8px; }
        .card{ border:1px solid #e5e7eb; border-radius:8px; padding:10px; }
        .table{ width:100%; border-collapse: collapse; }
        .table th,.table td{ border-bottom:1px solid #e5e7eb; padding:8px; vertical-align:top; }
        .badge{ display:inline-block; padding:3px 8px; border-radius:999px; font-size:11px; }
        .badge-success{ background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; }
        .badge-danger{ background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
        .thumb{ max-height:60px; border:1px solid #e5e7eb; border-radius:6px; }
    </style>
</head>
<body>
    @php
        // Use remote logo as requested (Dompdf must have isRemoteEnabled=true)
        $logoUrl = 'https://toploker.com/assets/images/perusahaan/profile/multindo.jpg';
    @endphp
    <div class="letterhead">
        <div class="lh-left">
            <img src="{{ $logoUrl }}" alt="Logo">
        </div>
        <div class="lh-right">
            <div class="company">PT. Multindo Technology Utama</div>
            <div class="tagline">Mining &amp; Industrial Service</div>
            <div class="address">Jl. Raya Mustikasari No.124, RT.001/RW.4, Padurenan, Kec. Mustika Jaya, Kota Bks, Jawa Barat 16340</div>
        </div>
    </div>
    <h1>Review Hasil Psikotes</h1>
    <div class="muted">Dicetak: {{ now()->format('d M Y H:i') }}</div>

    <div class="grid" style="margin:10px 0;">
        <div class="card">
            <div class="muted">Nama</div>
            <div><strong>{{ optional($result->user)->name }}</strong></div>
        </div>
        <div class="card">
            <div class="muted">Email</div>
            <div><strong>{{ optional($result->user)->email }}</strong></div>
        </div>
        <div class="card">
            <div class="muted">Skor</div>
            <div><strong>{{ number_format($result->score,1) }}%</strong></div>
        </div>
    </div>

    <h2>Jawaban</h2>
    <table class="table">
        <thead>
            <tr>
                <th style="width:32px;">#</th>
                <th>Pertanyaan</th>
                <th>Jawaban Kandidat</th>
                <th style="width:160px;">Kunci</th>
                <th style="width:80px;">Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $row)
            @php($soal=$row['soal'])
            <tr>
                <td>{{ $row['index'] }}</td>
                <td>
                    @if(($row['type_soal'] ?? 'teks') === 'foto')
                        <img src="{{ Storage::url($soal?->soal) }}" class="thumb" alt="Soal">
                    @else
                        {{ $soal?->soal }}
                    @endif
                </td>
                <td>
                    @if(($row['type_jawaban'] ?? 'teks') === 'foto')
                        <img src="{{ Storage::url(optional($soal)->{'pilihan_' . $row['user_answer']}) }}" class="thumb" alt="Jawaban">
                    @else
                        {{ optional($soal)->{'pilihan_' . $row['user_answer']} }}
                    @endif
                </td>
                <td>
                    @if(($row['type_jawaban'] ?? 'teks') === 'foto')
                        <img src="{{ Storage::url(optional($soal)->{'pilihan_' . $row['correct_index']}) }}" class="thumb" alt="Kunci">
                    @else
                        {{ optional($soal)->{'pilihan_' . $row['correct_index']} }}
                    @endif
                </td>
                <td>
                    @if($row['is_correct'])
                        <span class="badge badge-success">Benar</span>
                    @else
                        <span class="badge badge-danger">Salah</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
