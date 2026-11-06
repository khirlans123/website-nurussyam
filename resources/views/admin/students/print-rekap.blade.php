<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Data Santri Aktif - Ma'had Nurussyam</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            padding: 24px 20px;
            font-size: 11.5px;
            line-height: 1.45;
        }

        /* Toolbar Layar (Tidak ikut tercetak) */
        .no-print-toolbar {
            max-width: 1100px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-print {
            background: #0f8528;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(15, 133, 40, 0.25);
        }

        .btn-print:hover {
            background: #092a14;
        }

        .btn-excel {
            background: #10b981;
            color: #ffffff;
        }

        .btn-excel:hover {
            background: #059669;
        }

        .btn-back {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-back:hover {
            background: #cbd5e1;
        }

        /* Kertas Dokumen Fisik / Hard File */
        .paper-document {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px 36px;
            border-radius: 6px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #cbd5e1;
        }

        /* Kop Surat Resmi */
        .kop-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding-bottom: 12px;
            border-bottom: 3px double #0f172a;
            margin-bottom: 18px;
        }

        .kop-logo {
            width: 75px;
            height: 75px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .kop-text {
            text-align: center;
            flex: 1;
        }

        .kop-title-ar {
            font-family: 'Amiri', serif;
            font-size: 20px;
            color: #0f8528;
            margin-bottom: 2px;
            line-height: 1.2;
        }

        .kop-title-id {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #0f172a;
        }

        .kop-sub {
            font-size: 12px;
            font-weight: 600;
            color: #334155;
            margin-top: 1px;
        }

        .kop-address {
            font-size: 10px;
            color: #64748b;
            margin-top: 3px;
        }

        /* Header Laporan */
        .report-header {
            text-align: center;
            margin-bottom: 16px;
        }

        .report-title {
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        .report-subtitle {
            font-size: 11px;
            color: #475569;
        }

        /* Summary Chips */
        .meta-chips {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin: 10px 0 16px;
            font-size: 10.5px;
        }

        .meta-chip {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 4px 10px;
            border-radius: 4px;
            color: #334155;
        }

        .meta-chip strong {
            color: #0f8528;
        }

        /* Tabel Data Santri */
        .rekap-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 10.5px;
        }

        .rekap-table th,
        .rekap-table td {
            border: 1px solid #475569;
            padding: 6px 7px;
            text-align: left;
            vertical-align: middle;
        }

        .rekap-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: 800;
            text-align: center;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .rekap-table tbody tr:nth-child(even) {
            background-color: #fbfcfe;
        }

        .col-center {
            text-align: center !important;
        }

        .col-nowrap {
            white-space: nowrap;
        }

        /* Tanda Tangan */
        .signature-grid {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 10px;
            page-break-inside: avoid;
        }

        .sig-box {
            width: 250px;
            text-align: center;
            font-size: 11px;
            color: #1e293b;
        }

        .sig-space {
            height: 70px;
        }

        .sig-name {
            font-weight: 800;
            text-decoration: underline;
            color: #0f172a;
            font-size: 11.5px;
        }

        .sig-role {
            font-size: 10.5px;
            color: #475569;
            margin-top: 2px;
        }

        /* Footer Nota */
        .print-footer {
            margin-top: 25px;
            padding-top: 8px;
            border-top: 1px dashed #cbd5e1;
            display: flex;
            justify-content: space-between;
            font-size: 9.5px;
            color: #94a3b8;
        }

        /* PRINT MEDIA QUERIES */
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm 8mm;
            }

            body {
                background: #ffffff !important;
                padding: 0 !important;
                font-size: 10px;
                color: #000000;
            }

            .no-print-toolbar {
                display: none !important;
            }

            .paper-document {
                max-width: 100% !important;
                width: 100% !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .rekap-table {
                font-size: 9.5px;
            }

            .rekap-table th,
            .rekap-table td {
                border-color: #000000 !important;
                padding: 4px 5px !important;
            }

            .rekap-table th {
                background-color: #e5e7eb !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- TOOLBAR LAYAR (Hanya tampil di browser, otomatis hilang saat diprint) -->
    <div class="no-print-toolbar">
        <div>
            <strong style="color: #0f8528; font-size: 15px; display: block;">
                <i class="fa-solid fa-file-invoice"></i> Format Cetak Hard File / Berkas Fisik Santri
            </strong>
            <span style="font-size: 12px; color: #64748b;">
                Siap dicetak langsung ke kertas fisik (Printer) atau disimpan sebagai dokumen PDF resmi.
            </span>
        </div>

        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fa-solid fa-print"></i> Cetak Dokumen / Simpan PDF
            </button>
            <a href="{{ route('admin.students.export.excel', request()->all()) }}" class="btn-action btn-excel">
                <i class="fa-solid fa-file-excel"></i> Unduh File Excel (.csv)
            </a>
            <a href="{{ route('admin.students.index', request()->all()) }}" class="btn-action btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Santri
            </a>
        </div>
    </div>

    <!-- DOKUMEN CETAK UTAMA (HARD COPY) -->
    <div class="paper-document">
        
        <!-- Kop Surat Resmi -->
        <div class="kop-wrapper">
            <img src="{{ asset('images/logo-ppns.png') }}" alt="Logo PP Nurussyam" class="kop-logo">
            <div class="kop-text">
                <div class="kop-title-ar">&#1605;&#1593;&#1607;&#1583; &#1606;&#1608;&#1585; &#1575;&#1604;&#1588;&#1575;&#1605; &#1575;&#1604;&#1573;&#1587;&#1604;&#1575;&#1605;&#1610;</div>
                <div class="kop-title-id">MA'HAD NURUSSYAM</div>
                <div class="kop-sub">WRINGIN ARAK-ARAK BONDOWOSO JAWA TIMUR</div>
                <div class="kop-address">
                    Jl. Raya Bondowoso - Besuki, Desa Wringin, Kec. Wringin, Kab. Bondowoso, Jawa Timur 68252 &bull; Kontak: 0812-3456-7890
                </div>
            </div>
            <div style="width: 75px; flex-shrink: 0;"></div>
        </div>

        <!-- Header Laporan -->
        <div class="report-header">
            <h1 class="report-title">DAFTAR REKAPITULASI RESMI DATA SANTRI AKTIF</h1>
            <p class="report-subtitle">
                Direktori santri resmi yang telah diterima dan menempuh pendidikan di Ma'had Nurussyam
            </p>

            <div class="meta-chips">
                <div class="meta-chip">
                    Total Santri: <strong>{{ $stats['total'] }}</strong>
                </div>
                <div class="meta-chip">
                    Santri Putra: <strong>{{ $stats['putra'] }}</strong>
                </div>
                <div class="meta-chip">
                    Santri Putri: <strong>{{ $stats['putri'] }}</strong>
                </div>
                <div class="meta-chip">
                    Jenjang MTs: <strong>{{ $stats['mts'] }}</strong> &bull; MA: <strong>{{ $stats['ma'] }}</strong>
                </div>
                @if(!empty($filterInfo['jenjang']))
                    <div class="meta-chip" style="border-color: #86efac; background: #f0fdf4;">
                        Filter Jenjang: <strong>{{ $filterInfo['jenjang'] }}</strong>
                    </div>
                @endif
                @if(!empty($filterInfo['gender']))
                    <div class="meta-chip" style="border-color: #93c5fd; background: #eff6ff;">
                        Filter Gender: <strong>{{ $filterInfo['gender'] }}</strong>
                    </div>
                @endif
                <div class="meta-chip">
                    Tanggal Cetak: <strong>{{ now()->translatedFormat('d F Y') }}</strong>
                </div>
            </div>
        </div>

        <!-- Tabel Data Santri -->
        <table class="rekap-table">
            <thead>
                <tr>
                    <th style="width: 28px;">No</th>
                    <th style="width: 105px;">No. Induk / Reg</th>
                    <th style="min-width: 140px;">Nama Lengkap Santri</th>
                    <th style="width: 45px;">L/P</th>
                    <th style="width: 85px;">NISN / NIK</th>
                    <th style="width: 100px;">Tempat, Tgl Lahir</th>
                    <th style="width: 105px;">Jenjang</th>
                    <th style="width: 110px;">Nama Wali</th>
                    <th style="width: 90px;">No. WhatsApp</th>
                    <th style="min-width: 110px;">Asal Sekolah</th>
                    <th style="min-width: 130px;">Alamat Asal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $index => $st)
                    <tr>
                        <td class="col-center">{{ $index + 1 }}</td>
                        <td class="col-nowrap">
                            <strong>{{ $st->no_pendaftaran }}</strong>
                        </td>
                        <td>
                            <strong>{{ $st->nama_lengkap }}</strong>
                        </td>
                        <td class="col-center">
                            @if($st->jenis_kelamin === 'Laki-laki')
                                <span>L</span>
                            @else
                                <span>P</span>
                            @endif
                        </td>
                        <td class="col-nowrap" style="font-size: 9px;">
                            <div>{{ $st->nisn ? 'NISN: '.$st->nisn : '-' }}</div>
                            <div>{{ $st->nik ? 'NIK: '.$st->nik : '' }}</div>
                        </td>
                        <td>
                            {{ $st->tempat_lahir ?? '-' }}, {{ $st->tanggal_lahir ? $st->tanggal_lahir->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            {{ str_replace('Salafiyah', "Ma'had Nurussyam", $st->pilihan_jenjang) }}
                        </td>
                        <td>
                            {{ $st->nama_wali ?? '-' }}
                        </td>
                        <td class="col-nowrap">
                            {{ $st->no_wa ?? '-' }}
                        </td>
                        <td>
                            {{ $st->asal_sekolah ?? '-' }}
                        </td>
                        <td style="font-size: 9.5px;">
                            {{ $st->alamat ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="col-center" style="padding: 24px; color: #64748b;">
                            Tidak ada data santri yang memenuhi kriteria filter saat ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Kolom Tanda Tangan Resmi Pengasuh & Panitia -->
        <div class="signature-grid">
            <div class="sig-box">
                <div>Mengetahui,</div>
                <div class="sig-role">Sekretariat / Panitia Kesantrian</div>
                <div class="sig-space"></div>
                <div class="sig-name">( ............................................ )</div>
                <div class="sig-role">NIP / NIY. ...............................</div>
            </div>

            <div class="sig-box">
                <div>Bondowoso, {{ now()->translatedFormat('d F Y') }}</div>
                <div class="sig-role">Pengasuh Pondok Pesantren Nurussyam</div>
                <div class="sig-space"></div>
                <div class="sig-name">K.H. Abdul Malik Sanusi</div>
                <div class="sig-role">Pengasuh Pondok Pesantren</div>
            </div>
        </div>

        <!-- Footer Dokumen -->
        <div class="print-footer">
            <span>Dicetak secara resmi melalui Sistem Informasi Manajemen PP. Nurussyam Wringin Bondowoso</span>
            <span>Halaman 1 &bull; Dokumen Sah Hard File</span>
        </div>

    </div>

</body>
</html>

