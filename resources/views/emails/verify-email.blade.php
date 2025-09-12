<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Verifikasi Email' }}</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2d3d;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">Verifikasi email akun Anda</div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f4f6f8;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="width:600px;max-width:100%;background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                    <tr>
                        <td align="center" style="padding:24px;background:#ffffff;border-bottom:1px solid #eef2f7;">
                            <img src="https://www.multindo-technology.com/img/logomultindo-transparent.png" alt="Multindo Technology" style="height:46px;display:block;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 24px 8px 24px;">
                            <h2 style="margin:0;font-size:20px;line-height:1.4;color:#0f172a;">Verifikasi Email Akun</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 24px 24px 24px;">
                            <p style="margin:0 0 12px 0;font-size:14px;color:#334155;">Halo, <strong>{{ $candidate ?? 'Pengguna' }}</strong></p>
                            <p style="margin:0 0 12px 0;font-size:14px;color:#334155;">Terima kasih telah mendaftar. Silakan verifikasi email Anda untuk mengaktifkan akun.</p>
                            @if(!empty($verificationUrl))
                                <div style="margin:24px 0;">
                                    <a href="{{ $verificationUrl }}" style="background:#2563eb;color:#ffffff;text-decoration:none;padding:12px 18px;border-radius:8px;display:inline-block;font-weight:600;font-size:14px;">Verifikasi Email</a>
                                </div>
                                <p style="margin:0;font-size:12px;color:#94a3b8;">Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke peramban Anda:<br>
                                    <span style="word-break:break-all;color:#2563eb;">{{ $verificationUrl }}</span>
                                </p>
                            @endif
                            <p style="margin:16px 0 0 0;font-size:12px;color:#64748b;">Untuk keamanan, tautan verifikasi memiliki batas waktu. Bila kedaluwarsa, Anda dapat meminta tautan baru dari halaman login.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 24px;background:#f8fafc;border-top:1px solid #eef2f7;">
                            <p style="margin:0 0 6px 0;font-size:12px;color:#94a3b8;">Email ini dikirim otomatis. Mohon tidak membalas email ini.</p>
                            <p style="margin:0;font-size:12px;color:#94a3b8;">&copy; {{ date('Y') }} Multindo Technology. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

