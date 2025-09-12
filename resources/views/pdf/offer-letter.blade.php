<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Offering Letter</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #1f2937; font-size: 12px; }
        .container { padding: 24px; }
        .header { text-align: center; margin-bottom: 16px; }
        .logo { height: 50px; }
        h1 { font-size: 20px; margin: 8px 0 0 0; }
        .meta { color: #6b7280; font-size: 11px; }
        .section { margin-top: 18px; }
        .box { border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; background: #f9fafb; }
        .row { margin: 6px 0; }
        .label { width: 150px; display: inline-block; color: #374151; }
        .value { color: #111827; }
        .signature { margin-top: 40px; }
    </style>
    <!-- Allow remote images for Dompdf (controller sets isRemoteEnabled) -->
</head>
<body>
    <div class="container">
        <div class="header">
            <img class="logo" src="https://www.multindo-technology.com/img/logomultindo-transparent.png" alt="Multindo Technology">
            <h1>Offering Letter</h1>
            <div class="meta">{{ ($issuedDate ?? now())->format('d M Y') }}</div>
        </div>

        <div class="section">
            <p>Kepada Yth,</p>
            <p><strong>{{ $candidateName ?? 'Kandidat' }}</strong></p>
            <p>Dengan hormat,</p>
            <p>
                Kami dengan senang hati menyampaikan bahwa Anda telah <strong>DITERIMA</strong> untuk posisi
                <strong>{{ $position ?? '-' }}</strong>@if(!empty($department)) ({{ $department }}) @endif di <strong>Multindo Technology</strong>.
            </p>
        </div>

        <div class="section box">
            <div class="row"><span class="label">Posisi</span><span class="value">: {{ $position ?? '-' }}</span></div>
            @if(!empty($department))<div class="row"><span class="label">Departemen</span><span class="value">: {{ $department }}</span></div>@endif
            @if(!empty($location))<div class="row"><span class="label">Lokasi Kerja</span><span class="value">: {{ $location }}</span></div>@endif
            @if(!empty($salary))<div class="row"><span class="label">Perkiraan Gaji</span><span class="value">: {{ $salary }}</span></div>@endif
        </div>

        <div class="section">
            <p>Detail lebih lanjut terkait dokumen administrasi, jadwal onboarding, dan keperluan lain akan kami informasikan menyusul. Jika Anda memiliki pertanyaan, silakan menghubungi kami.</p>
        </div>

        <div class="section signature">
            <p>Hormat kami,</p>
            <p><strong>Multindo Technology</strong></p>
        </div>
    </div>
</body>
</html>

