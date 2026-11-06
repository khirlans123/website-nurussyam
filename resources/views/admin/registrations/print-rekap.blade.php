<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Penerimaan Santri Baru (PSB) - Ma'had Nurussyam</title>

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

        .paper-document {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px 36px;
            border-radius: 6px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #cbd5e1;
        }

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

        .badge-status {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-diverifikasi { background: #e0f2fe; color: #0369a1; }
        .status-diterima { background: #dcfce7; color: #166534; }
        .status-ditolak { background: #fee2e2; color: #991b1b; }

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

        .print-footer {
            margin-top: 25px;
            padding-top: 8px;
            border-top: 1px dashed #cbd5e1;
            display: flex;
            justify-content: space-between;
            font-size: 9.5px;
            color: #94a3b8;
        }

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

    <div class="no-print-toolbar">
        <div>
            <strong style="color: #0f8528; font-size: 15px; display: block;">
                <i class="fa-solid fa-file-invoice"></i> Format Cetak Hard File / Berkas Fisik Pendaftaran PSB
            </strong>
            <span style="font-size: 12px; color: #64748b;">
                Siap dicetak langsung ke kertas fisik (Printer) atau disimpan sebagai dokumen PDF resmi.
            </span>
        </div>

        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fa-solid fa-print"></i> Cetak Dokumen / Simpan PDF
            </button>
            <a href="{{ route('admin.registrations.export.excel', request()->all()) }}" class="btn-action btn-excel">
                <i class="fa-solid fa-file-excel"></i> Unduh File Excel (.csv)
            </a>
            <a href="{{ route('admin.registrations.index', request()->all()) }}" class="btn-action btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Pendaftaran PSB
            </a>
        </div>
    </div>

    <div class="paper-document">
        
        <div class="kop-wrapper">
            <img src="{{ asset('images/logo-ppns.png') }}" alt="Logo PP Nurussyam" class="kop-logo">
            <div class="kop-text">
                <div class="kop-title-ar">&#1605;&#1593;&#1607;&#1583; &#1606;&#1608;&#1585; &#1575;&#1604;&#1588;&#1575;&#1605; &#1575;&#1604;&#1573;&#1587;&#1604;&#1575;&#1605;&#1610;</div>
                <div class="kop-title-id">PANITIA PENERIMAAN SANTRI BARU (PSB)</div>
                <div class="kop-sub">MA'HAD NURUSSYAM WRINGIN BONDOWOSO</div>
                <div class="kop-address">
                    Jl. Raya Bondowoso - Besuki, Desa Wringin, Kec. Wringin, Kab. Bondowoso, Jawa Timur 68252 &bull; Kontak: 0812-3456-7890
                </div>
            </div>
            <div style="width: 75px; flex-shrink: 0;"></div>
        </div>

        <div class="report-header">
            <h1 class="report-title">REKAPITULASI RESMI PENERIMAAN SANTRI BARU (PSB)</h1>
            <p class="report-subtitle">
                Daftar registrasi calon santri baru yang telah resmi diterima di Ma'had Nurussyam
            </p>

            <div class="meta-chips">
                <div class="meta-chip">
                    Total Santri Resmi: <strong>{{ $stats['total'] }} Santri</strong>
                </div>
                <div class="meta-chip">
                    Santri Putra: <strong>{{ $stats['putra'] }}</strong>
                </div>
                <div class="meta-chip">
                    Santri Putri: <strong>{{ $stats['putri'] }}</strong>
                </div>
                @if(!empty($filterInfo['jenjang']))
                    <div class="meta-chip">
                        Jenjang: <strong>{{ $filterInfo['jenjang'] }}</strong>
                    </div>
                @endif
                <div class="meta-chip">
                    Tahun Ajaran: <strong>{{ date('Y') }}/{{ date('Y') + 1 }}</strong>
                </div>
                <div class="meta-chip">
                    Tanggal Cetak: <strong>{{ now()->translatedFormat('d F Y') }}</strong>
                </div>
            </div>
        </div>

        <table class="rekap-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th style="width: 120px;">No. Pendaftaran</th>
                    <th style="min-width: 150px;">Nama Calon Santri</th>
                    <th style="width: 45px;">L/P</th>
                    <th style="width: 130px;">Jenjang Pilihan</th>
                    <th style="width: 120px;">Nama Orang Tua / Wali</th>
                    <th style="width: 105px;">No. WhatsApp</th>
                    <th style="min-width: 130px;">Asal Sekolah</th>
                    <th style="min-width: 140px;">Alamat</th>
                    <th style="width: 90px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $index => $r)
                    <tr>
                        <td class="col-center">{{ $index + 1 }}</td>
                        <td class="col-nowrap">
                            <strong>{{ $r->no_pendaftaran }}</strong>
                        </td>
                        <td>
                            <strong>{{ $r->nama_lengkap }}</strong>
                        </td>
                        <td class="col-center">
                            {{ $r->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}
                        </td>
                        <td>
                            {{ str_replace('Salafiyah', "Ma'had Nurussyam", $r->pilihan_jenjang) }}
                        </td>
                        <td>
                            {{ $r->nama_wali ?? '-' }}
                        </td>
                        <td class="col-nowrap">
                            {{ $r->no_wa ?? '-' }}
                        </td>
                        <td>
                            {{ $r->asal_sekolah ?? '-' }}
                        </td>
                        <td style="font-size: 9.5px;">
                            {{ $r->alamat ?? '-' }}
                        </td>
                        <td class="col-center" style="font-weight: 700; color: #166534;">
                            Resmi Diterima
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="col-center" style="padding: 24px; color: #64748b;">
                            Tidak ada data santri yang memenuhi kriteria filter cetak.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="signature-grid">
            <div class="sig-box">
                <div>Mengetahui,</div>
                <div class="sig-role">Ketua Panitia PSB Nurussyam</div>
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

        <div class="print-footer">
            <span>Dicetak secara resmi melalui Sistem Informasi Manajemen PP. Nurussyam Wringin Bondowoso</span>
            <span>Halaman 1 &bull; Dokumen Sah Hard File</span>
        </div>

    </div>

</body>
</html>

