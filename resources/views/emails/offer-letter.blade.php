<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offering Letter</title>
    <style>
        @media (prefers-color-scheme: dark) {
            body { background: #0b0f14 !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2d3d;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">Offering letter penerimaan kerja</div>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f4f6f8;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="width:600px;max-width:100%;background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                    <tr>
                        <td align="center" style="padding:20px;background:#ffffff;border-bottom:1px solid #eef2f7;">
                            <img src="https://www.multindo-technology.com/img/logomultindo-transparent.png" alt="Multindo Technology" style="height:46px;display:block;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 24px 8px 24px;">
                            <h2 style="margin:0;font-size:20px;line-height:1.4;color:#0f172a;">Offering Letter</h2>
                            <p style="margin:6px 0 0 0;font-size:12px;color:#64748b;">{{ now()->format('d M Y') }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 24px 24px 24px;">
                            <p style="margin:0 0 12px 0;font-size:14px;color:#334155;">Kepada Yth,</p>
                            <p style="margin:0 0 12px 0;font-size:14px;color:#334155;"><strong>{{ $candidateName ?? 'Kandidat' }}</strong></p>
                            <p style="margin:0 0 14px 0;font-size:14px;color:#334155;">Dengan hormat,</p>

                            <p style="margin:0 0 12px 0;font-size:14px;color:#334155;">
                                Kami dengan senang hati menyampaikan bahwa Anda telah <strong>DITERIMA</strong> untuk posisi
                                <strong>{{ $position ?? '-' }}</strong>
                                @if(!empty($department)) ({{ $department }}) @endif
                                di <strong>Multindo Technology</strong>.
                            </p>

                            <div style="margin:16px 0 18px 0;padding:12px;border:1px solid #e2e8f0;border-radius:10px;background:#f8fafc;">
                                <div style="font-size:13px;color:#0f172a;margin-bottom:8px;"><strong>Ringkasan Penawaran</strong></div>
                                <div style="font-size:13px;color:#334155;line-height:1.8;">
                                    <div><strong>Posisi:</strong> {{ $position ?? '-' }}</div>
                                    @if(!empty($department))<div><strong>Departemen:</strong> {{ $department }}</div>@endif
                                    @if(!empty($location))<div><strong>Lokasi Kerja:</strong> {{ $location }}</div>@endif
                                    @if(!empty($salary))<div><strong>Perkiraan Gaji:</strong> {{ $salary }}</div>@endif
                                    @if(!empty($startDate))<div><strong>Tanggal Mulai (rencana):</strong> {{ $startDate }}</div>@endif
                                </div>
                            </div>

                            <p style="margin:0 0 12px 0;font-size:14px;color:#334155;">
                                Detail lebih lanjut terkait dokumen administrasi, jadwal onboarding, dan keperluan lain akan kami informasikan menyusul.
                                Jika Anda memiliki pertanyaan, silakan menghubungi kami.
                            </p>

                            <p style="margin:16px 0 0 0;font-size:14px;color:#334155;">Hormat kami,</p>
                            <p style="margin:4px 0 12px 0;font-size:14px;color:#334155;">Multindo Technology</p>

                            <div style="margin-top:20px;">
                                @if(!empty($dashboardUrl))
                                    <a href="{{ $dashboardUrl }}" style="background:#2563eb;color:#ffffff;text-decoration:none;padding:10px 16px;border-radius:8px;display:inline-block;font-weight:600;font-size:14px;">Lihat di Dashboard</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 24px;background:#f8fafc;border-top:1px solid #eef2f7;">
                            <p style="margin:0 0 6px 0;font-size:12px;color:#94a3b8;">Email ini dikirim otomatis. Mohon tidak membalas.</p>
                            <p style="margin:0;font-size:12px;color:#94a3b8;">&copy; {{ date('Y') }} Multindo Technology. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

