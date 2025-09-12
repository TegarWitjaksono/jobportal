<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Pemberitahuan Keputusan Lamaran' }}</title>
    <style>
        /* Some clients ignore <style>, so keep critical styles inline below */
        @media (prefers-color-scheme: dark) {
            body { background: #0b0f14 !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2d3d;">
    <!-- Preheader (hidden) -->
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">Informasi keputusan lamaran Anda</div>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f4f6f8;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="width:600px;max-width:100%;background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                    <!-- Header / Logo -->
                    <tr>
                        <td align="center" style="padding:24px;background:#ffffff;border-bottom:1px solid #eef2f7;">
                            <img src="https://www.multindo-technology.com/img/logomultindo-transparent.png" alt="Multindo Technology" style="height:46px;display:block;">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td style="padding:24px 24px 8px 24px;">
                            <h2 style="margin:0;font-size:20px;line-height:1.4;color:#0f172a;">Pemberitahuan Keputusan Lamaran</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:8px 24px 24px 24px;">
                            <p style="margin:0 0 12px 0;font-size:14px;color:#334155;">Halo, <strong>{{ $candidate ?? 'Kandidat' }}</strong></p>
                            <p style="margin:0 0 12px 0;font-size:14px;color:#334155;">Kami ingin menyampaikan informasi terkait lamaran Anda untuk posisi <strong>“{{ $lowongan ?? 'Posisi yang dilamar' }}”</strong>.</p>

                            <!-- Status badge -->
                            @php($accepted = ($status ?? '') === 'diterima')
                            <div style="margin:16px 0 20px 0;">
                                <span style="display:inline-block;padding:8px 12px;border-radius:999px;font-weight:600;font-size:12px;letter-spacing:.3px;{{ $accepted ? 'background:#ecfdf5;color:#047857;border:1px solid #a7f3d0;' : 'background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;' }}">
                                    Status: {{ $accepted ? 'DITERIMA' : ( ($status ?? '') === 'ditolak' ? 'DITOLAK' : strtoupper($status ?? '')) }}
                                </span>
                            </div>

                            @if($accepted)
                                <p style="margin:0 0 12px 0;font-size:14px;color:#334155;">Selamat! Anda lolos pada proses seleksi ini. Tim kami akan menghubungi Anda untuk informasi tahap berikutnya.</p>
                            @elseif(($status ?? '') === 'ditolak')
                                <p style="margin:0 0 12px 0;font-size:14px;color:#334155;">Terima kasih telah meluangkan waktu untuk mengikuti proses seleksi. Saat ini kami belum dapat melanjutkan proses lamaran Anda.</p>
                            @endif

                            @if(!empty($officerName))
                                <p style="margin:0 0 16px 0;font-size:13px;color:#64748b;">Keputusan ditetapkan oleh: <strong>{{ $officerName }}</strong></p>
                            @endif

                            <!-- CTA Button -->
                            @if(!empty($dashboardUrl))
                                <div style="margin:24px 0;">
                                    <a href="{{ $dashboardUrl }}" style="background:#2563eb;color:#ffffff;text-decoration:none;padding:12px 18px;border-radius:8px;display:inline-block;font-weight:600;font-size:14px;">Lihat Status Lamaran</a>
                                </div>
                                <p style="margin:0;font-size:12px;color:#94a3b8;">Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke peramban Anda:<br>
                                    <span style="word-break:break-all;color:#2563eb;">{{ $dashboardUrl }}</span>
                                </p>
                            @endif
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px 24px;background:#f8fafc;border-top:1px solid #eef2f7;">
                            <p style="margin:0 0 6px 0;font-size:12px;color:#94a3b8;">Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
                            <p style="margin:0;font-size:12px;color:#94a3b8;">&copy; {{ date('Y') }} Multindo Technology. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

