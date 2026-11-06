<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Santri & Biodata Resmi - {{ $student->nama_lengkap }} ({{ $student->no_pendaftaran }})</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/toast-notification.css') }}?v=1.0">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            padding: 30px 20px;
            font-size: 13px;
        }

        .no-print-toolbar {
            max-width: 800px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        .btn-print {
            background: #0f8528;
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .btn-print:hover {
            background: #092a14;
        }

        .btn-back {
            background: #e2e8f0;
            color: #334155;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .sheet-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        /* Card Preview */
        .kts-card-wrapper {
            margin-bottom: 35px;
            display: flex;
            justify-content: center;
        }

        .kts-card {
            width: 480px;
            height: 290px;
            background: linear-gradient(135deg, #092a14 0%, #0f8528 50%, #064e18 100%);
            border-radius: 16px;
            color: #ffffff;
            padding: 20px;
            position: relative;
            box-shadow: 0 10px 25px rgba(15, 133, 40, 0.35);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .kts-card::after {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(253, 224, 71, 0.15) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .kts-header {
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.25);
            padding-bottom: 10px;
        }

        .kts-header img {
            width: 44px;
            height: 44px;
            object-fit: contain;
            background: #ffffff;
            border-radius: 50%;
            padding: 3px;
        }

        .kts-header-text h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #fde047;
            font-weight: 800;
        }

        .kts-header-text h2 {
            font-size: 15px;
            font-weight: 800;
            line-height: 1.2;
        }

        .kts-header-text p {
            font-size: 9px;
            color: #bbf7d0;
        }

        .kts-body {
            display: flex;
            gap: 16px;
            align-items: center;
            margin-top: 10px;
        }

        .kts-photo {
            width: 85px;
            height: 105px;
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: rgba(255,255,255,0.7);
            flex-shrink: 0;
        }

        .kts-details {
            flex: 1;
            font-size: 11px;
            line-height: 1.5;
        }

        .kts-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .kts-details td {
            padding: 2px 0;
            vertical-align: top;
            color: #f0fdf4;
        }

        .kts-details td.label {
            width: 75px;
            color: #bbf7d0;
            font-weight: 600;
        }

        .kts-details td.val {
            font-weight: 700;
            color: #ffffff;
        }

        .kts-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 8px;
            font-size: 9px;
            color: #bbf7d0;
        }

        .kts-badge {
            background: #fde047;
            color: #064e18;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Formal Dossier Section */
        .kop-surat {
            display: flex;
            align-items: center;
            gap: 18px;
            border-bottom: 3px double #0f8528;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .kop-surat img {
            width: 75px;
            height: 75px;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
            flex: 1;
        }

        .kop-text h3 {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #064e18;
            font-weight: 800;
        }

        .kop-text h2 {
            font-size: 20px;
            font-weight: 800;
            color: #0f8528;
            margin: 2px 0;
        }

        .kop-text p {
            font-size: 11px;
            color: #475569;
        }

        .doc-heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .doc-heading h1 {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
            border-bottom: 1px solid #cbd5e1;
            display: inline-block;
            padding-bottom: 4px;
        }

        .doc-heading p {
            font-size: 12px;
            color: #64748b;
            margin-top: 3px;
        }

        .formal-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 12.5px;
        }

        .formal-table th, .formal-table td {
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            vertical-align: top;
        }

        .formal-table th {
            background-color: #f8fafc;
            color: #334155;
            text-align: left;
            width: 220px;
            font-weight: 700;
        }

        .formal-table td {
            color: #0f172a;
        }

        .ttd-grid {
            display: flex;
            justify-content: space-between;
            margin-top: 35px;
            page-break-inside: avoid;
        }

        .ttd-box {
            text-align: center;
            width: 240px;
        }

        .ttd-space {
            height: 65px;
        }

        .ttd-name {
            font-weight: 700;
            text-decoration: underline;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .no-print-toolbar {
                display: none !important;
            }

            .sheet-container {
                box-shadow: none;
                padding: 0;
            }

            .kts-card {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Top Bar -->
    <div class="no-print-toolbar">
        <a href="{{ route('admin.students.show', $student) }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Detail Santri</span>
        </a>
        <div style="font-weight: 700; font-size: 14px; color: #0f8528;">
            <i class="fa-solid fa-id-card"></i> Lembar Kartu Santri & Biodata Resmi
        </div>
        <button onclick="if(window.showToast){ window.showToast({ title: 'Mencetak KTS Santri', message: 'Membuka dialog cetak dan unduh PDF Kartu Tanda Santri...', type: 'success', icon: 'ri-printer-fill', duration: 3200 }); } setTimeout(function(){ window.print(); }, 400);" class="btn-print" data-toast="Membuka dialog cetak dan simpan PDF Kartu Tanda Santri..." data-toast-title="Mencetak KTS Santri" data-toast-type="success" data-toast-icon="ri-printer-fill">
            <i class="fa-solid fa-print"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
    </div>

    <!-- Official Printable Sheet -->
    <div class="sheet-container">
        
        <!-- SECTION 1: KARTU TANDA SANTRI (KTS) -->
        <div class="kts-card-wrapper">
            <div class="kts-card">
                <div class="kts-header">
                    <img src="{{ asset('img/logo-nurussyam.png') }}" onerror="this.src='{{ asset('img/logo.png') }}'" alt="Logo">
                    <div class="kts-header-text">
                        <h3>Pondok Pesantren Nurussyam</h3>
                        <h2>KARTU TANDA SANTRI (KTS)</h2>
                        <p>Wringin, Bondowoso &bull; Jawa Timur</p>
                    </div>
                </div>

                <div class="kts-body">
                    <div class="kts-photo">
                        @if($student->jenis_kelamin === 'Laki-laki')
                            <i class="fa-solid fa-user-graduate"></i>
                        @else
                            <i class="fa-solid fa-user-tie"></i>
                        @endif
                    </div>
                    <div class="kts-details">
                        <table>
                            <tr>
                                <td class="label">Nama</td>
                                <td style="width: 10px;">:</td>
                                <td class="val" style="font-size: 12px; color: #fde047;">{{ $student->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td class="label">No. Induk</td>
                                <td>:</td>
                                <td class="val">{{ $student->no_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td class="label">Jenjang</td>
                                <td>:</td>
                                <td class="val">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $student->pilihan_jenjang) }}</td>
                            </tr>
                            <tr>
                                <td class="label">TTL</td>
                                <td>:</td>
                                <td class="val">{{ $student->tempat_lahir ?: '-' }}, {{ $student->tanggal_lahir ? $student->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Wali</td>
                                <td>:</td>
                                <td class="val">{{ $student->nama_wali }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="kts-footer">
                    <div>
                        <span>Status: </span>
                        <span class="kts-badge">SANTRI AKTIF</span>
                    </div>
                    <div style="text-align: right;">
                        <span>Pengasuh PP. Nurussyam</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: BIODATA INDUK SANTRI RESMI -->
        <div class="kop-surat">
            <img src="{{ asset('img/logo-nurussyam.png') }}" onerror="this.src='{{ asset('img/logo.png') }}'" alt="Logo PP. Nurussyam">
            <div class="kop-text">
                <h3>Yayasan Pondok Pesantren Nurussyam</h3>
                <h2>PONDOK PESANTREN NURUSSYAM</h2>
                <p>Jl. Raya Wringin No. 45, Kec. Wringin, Kab. Bondowoso, Jawa Timur 68252</p>
                <p>Email: admin@nurussyam.ponpes.id &bull; Website: www.nurussyam.ponpes.id</p>
            </div>
        </div>

        <div class="doc-heading">
            <h1>BIODATA INDUK SANTRI RESMI</h1>
            <p>Nomor Induk / Registrasi: <strong>{{ $student->no_pendaftaran }}</strong></p>
        </div>

        <table class="formal-table">
            <tr>
                <th>Nama Lengkap Santri</th>
                <td><strong>{{ $student->nama_lengkap }}</strong></td>
            </tr>
            <tr>
                <th>Nomor Induk / Registrasi</th>
                <td><code>{{ $student->no_pendaftaran }}</code></td>
            </tr>
            <tr>
                <th>Jenjang Pendidikan</th>
                <td><strong>{{ str_replace('Salafiyah', "Ma'had Nurussyam", $student->pilihan_jenjang) }}</strong></td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $student->jenis_kelamin }}</td>
            </tr>
            <tr>
                <th>NISN / NIK</th>
                <td>{{ $student->nisn ?: '-' }} / {{ $student->nik ?: '-' }}</td>
            </tr>
            <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>{{ $student->tempat_lahir ?: '-' }}, {{ $student->tanggal_lahir ? $student->tanggal_lahir->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <th>Asal Sekolah Sebelumnya</th>
                <td>{{ $student->asal_sekolah ?: '-' }}</td>
            </tr>
            <tr>
                <th>Nama Orang Tua / Wali</th>
                <td>{{ $student->nama_wali }}</td>
            </tr>
            <tr>
                <th>No. Telepon / WhatsApp</th>
                <td>{{ $student->no_wa }}</td>
            </tr>
            <tr>
                <th>Alamat Lengkap</th>
                <td>{{ $student->alamat }}</td>
            </tr>
            <tr>
                <th>Status Keaktifan</th>
                <td><strong style="color: #0f8528;">RESMI DITERIMA &bull; SANTRI AKTIF</strong></td>
            </tr>
            <tr>
                <th>Tanggal Penetapan</th>
                <td>{{ $student->updated_at->format('d F Y') }}</td>
            </tr>
        </table>

        <!-- Signatures -->
        <div class="ttd-grid">
            <div class="ttd-box">
                <div>Wali Santri,</div>
                <div class="ttd-space"></div>
                <div class="ttd-name">{{ $student->nama_wali }}</div>
            </div>

            <div class="ttd-box">
                <div>Bondowoso, {{ date('d F Y') }}</div>
                <div>Kepala Bagian Administrasi Santri,</div>
                <div class="ttd-space"></div>
                <div class="ttd-name">Panitia Kesantrian Nurussyam</div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/toast-notification.js') }}?v=1.0"></script>
</body>
</html>
