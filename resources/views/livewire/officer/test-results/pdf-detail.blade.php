<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Hasil Psikotes</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #1e293b; font-size: 12px; }
        .h1{ font-size: 20px; font-weight: 700; margin: 0 0 6px; }
        .h2{ font-size: 16px; font-weight: 700; margin: 18px 0 8px; }
        .muted{ color:#64748b; }
        .letterhead{ display:flex; align-items:center; gap:12px; padding-bottom:8px; border-bottom:2px solid #e5e7eb; margin-bottom:14px; }
        .lh-left img{ max-height:42px; }
        .lh-right .company{ font-size:16px; font-weight:700; line-height:1.2; color:#111827; }
        .lh-right .tagline{ font-size:12px; font-weight:600; color:#1f2937; }
        .lh-right .address{ font-size:11px; color:#6b7280; }
        .grid{ display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
        .grid-2{ display:grid; grid-template-columns: repeat(2,1fr); gap:8px; }
        .card{ border:1px solid #e5e7eb; border-radius:8px; padding:10px; }
        .row{ display:flex; gap:8px; align-items:center; }
        .badge{ display:inline-block; padding:4px 8px; border-radius:999px; font-size:11px; }
        .badge-success{ background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; }
        .badge-danger{ background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
        .table{ width:100%; border-collapse: collapse; }
        .table th,.table td{ padding:8px; border-bottom:1px solid #e5e7eb; text-align:left; vertical-align: top; }
        .right{ text-align:right; }
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
        <div class="h1">Detail Hasil Psikotes</div>
        <div class="muted" style="margin-bottom:14px;">Dicetak: {{ now()->format('d M Y H:i') }}</div>

        <div class="grid-2" style="margin-bottom: 10px;">
            <div class="card">
                <div class="muted">Nama</div>
                <div><strong>{{ optional($result->user)->name }}</strong></div>
            </div>
            <div class="card">
                <div class="muted">Email</div>
                <div><strong>{{ optional($result->user)->email }}</strong></div>
            </div>
        </div>

        <div class="grid" style="margin-bottom: 12px;">
            <div class="card">
                <div class="muted">Skor</div>
                <div><strong>{{ number_format($result->score, 1) }}%</strong></div>
            </div>
            <div class="card">
                <div class="muted">Benar</div>
                <div><strong>{{ $result->correct_answers }}</strong></div>
            </div>
            <div class="card">
                <div class="muted">Total Soal</div>
                <div><strong>{{ $result->total_questions }}</strong></div>
            </div>
            <div class="card">
                <div class="muted">Status Akhir</div>
                <div>
                    @if($result->score >= 70)
                        <span class="badge badge-success">Lulus</span>
                    @else
                        <span class="badge badge-danger">Tidak Lulus</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid-2" style="margin-bottom: 8px;">
            <div class="card">
                <div class="muted">Waktu Mulai</div>
                <div><strong>{{ optional($result->started_at)->format('d M Y, H:i') }}</strong></div>
            </div>
            <div class="card">
                <div class="muted">Waktu Selesai</div>
                <div><strong>{{ optional($result->completed_at)->format('d M Y, H:i') ?? '-' }}</strong></div>
            </div>
        </div>

        <table class="table" style="margin-top: 10px;">
            <thead>
            <tr>
                <th style="width: 20%;">Ringkasan</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Status</td>
                <td>
                    @if($result->completed_at)
                        Selesai dalam {{ number_format($result->started_at->diffInSeconds($result->completed_at) / 60, 1) }} menit
                    @else
                        Belum selesai
                    @endif
                </td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td class="muted">Export ini memuat ringkasan yang sama dengan modal detail pada aplikasi.</td>
            </tr>
            </tbody>
        </table>
    </body>
    </html>
