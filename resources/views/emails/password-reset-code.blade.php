<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Reset Password - Pondok Pesantren Nurussyam</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1e293b;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f1f5f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 540px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #0f8528 0%, #074714 100%); padding: 30px 20px; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 20px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">
                                Pondok Pesantren Nurussyam
                            </h1>
                            <p style="margin: 5px 0 0; font-size: 13px; color: #e2e8f0; font-style: italic;">
                                Panel Pengelola &bull; Pemulihan Akun
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px 25px;">
                            <p style="margin: 0 0 16px; font-size: 15px; line-height: 1.6; color: #334155;">
                                <strong>Assalamu'alaikum Warahmatullahi Wabarakatuh,</strong><br>
                                Yth. <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="margin: 0 0 20px; font-size: 14px; line-height: 1.6; color: #475569;">
                                Kami menerima permintaan untuk mengatur ulang password akun pengelola Anda dengan email: <strong style="color: #0f8528;">{{ $user->email }}</strong>.
                            </p>

                            <!-- Code Box -->
                            <div style="background-color: #f0fdf4; border: 2px dashed #16a34a; border-radius: 10px; padding: 20px; text-align: center; margin: 25px 0;">
                                <span style="display: block; font-size: 12px; font-weight: 700; color: #166534; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">
                                    Kode Verifikasi Anda
                                </span>
                                <div style="font-size: 34px; font-weight: 800; letter-spacing: 10px; color: #0f8528; font-family: Consolas, 'Courier New', monospace; padding-left: 10px;">
                                    {{ $code }}
                                </div>
                                <span style="display: block; font-size: 12px; color: #15803d; margin-top: 8px;">
                                    <i style="color: #d97706;">&#9200;</i> Berlaku selama <strong>15 menit</strong>
                                </span>
                            </div>

                            <p style="margin: 0 0 16px; font-size: 13px; line-height: 1.6; color: #64748b;">
                                Masukkan 6 digit kode di atas pada halaman reset password untuk membuat password baru. Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan pesan ini dan akun Anda tetap aman.
                            </p>

                            <div style="border-top: 1px solid #e2e8f0; margin-top: 25px; padding-top: 18px; font-size: 12px; color: #94a3b8; text-align: center; line-height: 1.5;">
                                Pesan otomatis dari Sistem Informasi & Administrasi Pondok Pesantren Nurussyam Wringin Bondowoso.<br>
                                Mohon tidak membalas email ini secara langsung.
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f8fafc; padding: 14px 20px; font-size: 11px; color: #94a3b8; border-top: 1px solid #f1f5f9;">
                            &copy; {{ date('Y') }} Pondok Pesantren Nurussyam. Hak Cipta Dilindungi.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

