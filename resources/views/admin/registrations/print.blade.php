<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran PSB - {{ $registration->no_pendaftaran }}</title>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/toast-notification.css') }}?v=1.0">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            padding: 30px;
            font-size: 14px;
            line-height: 1.5;
        }

        .slip-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 30px;
            position: relative;
        }

        .header-kop {
            display: flex;
            align-items: center;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
            gap: 20px;
        }

        .header-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .header-text {
            text-align: center;
            flex: 1;
        }

        .header-text h2 {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header-text h1 {
            font-size: 22px;
            font-weight: 800;
            text-transform: uppercase;
            margin: 2px 0;
        }

        .header-text p {
            font-size: 12px;
            color: #333;
        }

        .doc-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .doc-title h3 {
            font-size: 16px;
            text-decoration: underline;
            text-transform: uppercase;
            font-weight: bold;
        }

        .doc-title span {
            font-size: 13px;
            font-family: monospace;
            font-weight: bold;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .table-data td {
            padding: 7px 10px;
            vertical-align: top;
            border: 1px solid #ccc;
        }

        .table-data td.label {
            width: 220px;
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .signature-area {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding: 0 30px;
        }

        .signature-box {
            text-align: center;
            width: 220px;
        }

        .signature-line {
            margin-top: 75px;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }

        .watermark-status {
            display: inline-block;
            border: 2px solid #0f8528;
            color: #0f8528;
            padding: 4px 12px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 13px;
            border-radius: 4px;
        }

        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #0f8528;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: sans-serif;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        @media print {
            .btn-print {
                display: none;
            }
            body {
                padding: 0;
            }
            .slip-container {
                border: 2px solid #000;
                margin: 0;
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <button onclick="if(window.showToast){ window.showToast({ title: 'Mencetak Bukti PSB', message: 'Membuka dialog cetak dan unduh slip pendaftaran...', type: 'success', icon: 'ri-printer-fill', duration: 3200 }); } setTimeout(function(){ window.print(); }, 400);" class="btn-print" data-toast="Membuka dialog cetak dan unduh slip pendaftaran..." data-toast-title="Mencetak Bukti PSB" data-toast-type="success" data-toast-icon="ri-printer-fill">🖨️ Cetak / Simpan PDF</button>

    <div class="slip-container">
        <!-- Kop Surat Resmi -->
        <div class="header-kop">
            <img src="{{ asset('images/logo-ppns.png') }}" alt="Logo" class="header-logo">
            <div class="header-text">
                <h2>YAYASAN PONDOK PESANTREN NURUS SYAM</h2>
                <h1>PONDOK PESANTREN NURUSSYAM</h1>
                <p>Jl. Raya Bondowoso - Besuki, Desa Wringin, Kec. Wringin, Kab. Bondowoso, Jawa Timur 68252</p>
                <p>Website Resmi: www.nurussyam.ponpes.id &bull; Telp/WA: +62 812-3456-7890</p>
            </div>
        </div>

        <div class="doc-title">
            <h3>BUKTI PENDAFTARAN SANTRI BARU (PSB)</h3>
            <span>Nomor Registrasi: {{ $registration->no_pendaftaran }}</span>
        </div>

        <table class="table-data">
            <tr>
                <td class="label">Pilihan Jenjang Pendidikan</td>
                <td><strong>{{ str_replace('Salafiyah', "Ma'had Nurussyam", $registration->pilihan_jenjang) }}</strong></td>
            </tr>
            <tr>
                <td class="label">Nama Lengkap Santri</td>
                <td><strong>{{ $registration->nama_lengkap }}</strong></td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td>{{ $registration->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td class="label">NISN / NIK</td>
                <td>{{ $registration->nisn ?: '-' }} / {{ $registration->nik ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tempat, Tanggal Lahir</td>
                <td>{{ $registration->tempat_lahir ?: '-' }}, {{ $registration->tanggal_lahir ? $registration->tanggal_lahir->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Asal Sekolah</td>
                <td>{{ $registration->asal_sekolah ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label">Nama Orang Tua / Wali</td>
                <td>{{ $registration->nama_wali ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label">Nomor WhatsApp / Telp</td>
                <td>{{ $registration->no_wa }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Lengkap</td>
                <td>{{ $registration->alamat ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label">Waktu Pendaftaran Online</td>
                <td>{{ $registration->created_at->format('d F Y, H:i:s') }} WIB</td>
            </tr>
            <tr>
                <td class="label">Status Verifikasi Berkas</td>
                <td>
                    <span class="watermark-status">{{ $registration->status }}</span>
                    @if($registration->catatan)
                        <div style="font-size: 12px; margin-top: 4px; color: #555;">Catatan: {{ $registration->catatan }}</div>
                    @endif
                </td>
            </tr>
        </table>

        <div style="font-size: 12px; color: #444; margin-bottom: 20px; line-height: 1.4;">
            <strong>Ketentuan:</strong>
            <ol style="margin-left: 20px; margin-top: 5px;">
                <li>Simpan bukti pendaftaran ini sebagai bukti registrasi resmi calon santri baru.</li>
                <li>Tunjukkan lembar ini kepada Panitia PSB pada saat daftar ulang di sekretariat pondok.</li>
                <li>Informasi seleksi & pengumuman resmi akan diinfokan melalui kontak WhatsApp terdaftar.</li>
            </ol>
        </div>

        <div class="signature-area">
            <div class="signature-box">
                <p>Orang Tua / Wali Santri,</p>
                <div class="signature-line">{{ $registration->nama_wali ?: '( .......................................... )' }}</div>
            </div>

            <div class="signature-box">
                <p>Bondowoso, {{ date('d F Y') }}<br>Panitia Penerimaan Santri Baru,</p>
                <div class="signature-line">Panitia PSB Nurussyam</div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/toast-notification.js') }}?v=1.0"></script>
</body>
</html>
