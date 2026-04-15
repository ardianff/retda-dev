<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lampiran Usulan Tarif</title>
    <style>
        @page { 
            size: folio landscape; 
            margin: 1.3cm 1.2cm 0.1cm 1.2cm;
        }

        /* Base Styles */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px; 
            margin: 0;
            transition: background-color 0.3s, color 0.3s;
        }

        .pdf-viewer {
            max-width: 1200px;
            margin: 20px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
            border-radius: 6px;
            overflow: hidden;
            transition: background-color 0.3s;
        }

        .pdf-toolbar {
            padding: 8px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .pdf-title {
            font-weight: bold;
            font-size: 14px;
            transition: color 0.3s;
        }

        .pdf-actions {
            display: flex;
            gap: 8px;
        }

        .pdf-actions button {
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: background-color 0.2s;
        }

        .pdf-content {
            padding: 20px;
            transition: background-color 0.3s;
        }

        table { 
            width: 100%; 
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td, th { 
            border: 1px solid;
            padding: 8px; 
            text-align: left;
            transition: border-color 0.3s, background-color 0.3s;
        }

        th { 
            text-align: center; 
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
        }

        tr {
            transition: background-color 0.3s;
        }

        h2 {
            border-bottom: 2px solid;
            padding-bottom: 8px;
            margin-top: 25px;
            margin-bottom: 15px;
            transition: color 0.3s, border-color 0.3s;
        }

        h3 {
            margin-top: 20px;
            margin-bottom: 10px;
            transition: color 0.3s;
        }

        .signature-section {
            text-align: right;
            margin-right: 50px;
            margin-top: 50px;
            padding: 20px 0;
            border-top: 1px solid;
            transition: border-color 0.3s;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid;
            margin: 5px auto;
            transition: border-color 0.3s;
        }
 /* Perbaikan khusus untuk tanda tangan */
 .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 300px; /* Lebar minimum untuk menjaga konsistensi */
        }

        .signature-name {
            margin: 10px 0 5px 0;
            font-size: 13px;
            font-weight: bold;
            transition: color 0.3s;
        }

        .signature-details {
            margin: 0;
            line-height: 1.4;
            transition: color 0.3s;
        }

        /* Light Mode Signature */
        .light-mode .signature-name {
            color: #000;
        }

        .light-mode .signature-details {
            color: #333;
        }

        /* Dark Mode Signature */
        .dark-mode .signature-name {
            color: #fff;
        }

        .dark-mode .signature-details {
            color: #e0e0e0;
        }
        .page-number {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
            transition: color 0.3s;
        }

        /* Light Mode */
        body.light-mode {
            background-color: #e8e8e8;
            color: #444;
        }

        .light-mode .pdf-viewer {
            background: white;
        }

        .light-mode .pdf-toolbar {
            background: #d0d0d0;
            border-color: #aaa;
        }

        .light-mode .pdf-title {
            color: #333;
        }

        .light-mode .pdf-actions button {
            background: #3a5683;
        }

        .light-mode .pdf-actions button:hover {
            background: #2c4366;
        }

        .light-mode .pdf-content {
            background-color: #fafafa;
        }

        .light-mode td, 
        .light-mode th {
            border-color: #bbb;
        }

        .light-mode th {
            background-color: #e0e0e0;
            color: #333;
        }

        .light-mode tr:nth-child(even) {
            background-color: #f0f0f0;
        }

        .light-mode tr:hover {
            background-color: #e6e6e6;
        }

        .light-mode h2 {
            color: #2a3a50;
            border-color: #ddd;
        }

        .light-mode h3 {
            color: #3a4a5e;
        }

        .light-mode .signature-section,
        .light-mode .signature-line {
            border-color: #ccc;
        }

        .light-mode .page-number {
            color: #666;
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #2a2a2a;
            color: #e0e0e0;
        }

        .dark-mode .pdf-viewer {
            background: #1e1e1e;
        }

        .dark-mode .pdf-toolbar {
            background: #3a3a3a;
            border-color: #555;
        }

        .dark-mode .pdf-title {
            color: #f0f0f0;
        }

        .dark-mode .pdf-actions button {
            background: #5a7ab8;
        }

        .dark-mode .pdf-actions button:hover {
            background: #4a6aa8;
        }

        .dark-mode .pdf-content {
            background-color: #252525;
        }

        .dark-mode td, 
        .dark-mode th {
            border-color: #444;
        }

        .dark-mode th {
            background-color: #3a3a3a;
            color: #f0f0f0;
        }

        .dark-mode tr:nth-child(even) {
            background-color: #2e2e2e;
        }

        .dark-mode tr:hover {
            background-color: #363636;
        }

        .dark-mode h2 {
            color: #8ab4f8;
            border-color: #444;
        }

        .dark-mode h3 {
            color: #a8c6f8;
        }

        .dark-mode .signature-section,
        .dark-mode .signature-line {
            border-color: #555;
        }

        .dark-mode .page-number {
            color: #999;
        }

        @media print {
            body {
                background: none !important;
                margin: 0;
                color: #000 !important;
            }
            
            .pdf-viewer {
                max-width: 100% !important;
                box-shadow: none !important;
                margin: 0 !important;
                background: white !important;
            }
            
            .pdf-toolbar {
                display: none !important;
            }
            .signature-name {
                color: #000 !important;
            }
            
            .signature-details {
                color: #000 !important;
            }
            @page {
                size: folio landscape;
                margin: 1.3cm 1.2cm 0.1cm 1.2cm;
            }

            .pdf-content {
                background-color: white !important;
                padding: 0 !important;
                color: #000 !important;
            }

            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
                background-color: white !important;
            }

            td, th {
                border-color: #000 !important;
                background-color: white !important;
                color: #000 !important;
            }

            h2, h3 {
                color: #000 !important;
            }
        }
    </style>
</head>
<body class="light-mode">
    <div class="pdf-viewer">
        <div class="pdf-toolbar">
            <div class="pdf-title">Lampiran Usulan Tarif</div>
            <div class="pdf-actions">
                <button id="toggleMode">🌓 Mode Gelap</button>
                <button onclick="window.print()">🖨 Cetak / Simpan PDF</button>
                <button onclick="window.close()">✖ Tutup</button>
            </div>
        </div>

        <div class="pdf-content">
            <!-- Your content here (same as previous versions) -->
            @foreach ($uppd as $b)
                @php
                    $jenisTersedia = $data->filter(function ($jenis) use ($b) {
                        return $jenis->usulan->where('uppd_id', $b->id)->count() > 0;
                    });
                @endphp

                @if ($jenisTersedia->count() > 0)
                    <h2>{{ $b->nama ?? '' }}</h2>

                    @foreach ($jenisTersedia as $jenis)
                        <h3>{{ $jenis->name ?? '' }}</h3>

                        <table>
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Uraian</th>
                                    <th rowspan="2">Satuan</th>

                                    @if ($jenis->id == 16)
                                        <th colspan="3">Tarif Semula</th>
                                        <th colspan="3">Tarif Menjadi</th>
                                        <th rowspan="2">%</th>
                                        <th rowspan="2">Keterangan</th>
                                    @else
                                        <th colspan="4">Tarif</th>
                                    @endif
                                    <th rowspan="2">Penjelasan</th>

                                   
                                </tr>

                                @if ($jenis->id == 16)
                                    <tr>
                                        <th>Jasa Sarana</th>
                                        <th>Jasa Layanan</th>
                                        <th>Tarif</th>
                                        <th>Jasa Sarana</th>
                                        <th>Jasa Layanan</th>
                                        <th>Tarif</th>
                                    </tr>
                                @else
                                    <tr>
                                        <th>Semula</th>
                                        <th>Usulan</th>
                                         <th >%</th>
                                    <th >Keterangan</th>
                                    </tr>
                                @endif
                            </thead>
                            <tbody>
                            @foreach ($jenis->usulan->where('uppd_id', $b->id)->where('parent_id', 0)->where('status', 1) as $parent)
                                @include('print.usulan.partials.usulanpdf', ['tarif' => $parent, 'level' => 0])
                            @endforeach
                                {{-- @foreach ($jenis->usulan->where('uppd_id', $b->id)->where('parent_id', 0) as $parent)
                                    @include('print.usulan.partials.usulanpdf', ['tarif' => $parent, 'level' => 0])
                                @endforeach --}}
                            </tbody>
                        </table>
                    @endforeach
                @endif
            @endforeach
            <div class="signature-section">
                <div class="signature-box">
        <p class="signature-details" style="margin-bottom: 0px;">{{$pejabat->kota}}, {{ tanggal_indonesia(date('Y-m-d')) }}</p>
                    @php
                    $antr = strtolower($pejabat->antr_waktu ?? '');
                    @endphp

                    {{-- Baris Jabatan --}}
                    <p class="signature-details" style="margin-top: 3px;">
                    @if($antr === 'plt' || $antr === 'plh')
                    {{ strtoupper($antr) }} {{ $pejabat->jabatan }}
                    @else
                    {{ $pejabat->jabatan }}
                    @endif
                    </p>

                    {{-- Baris Jabatan Utama (hanya kalau PLT/PLH) --}}
                    @if($antr === 'plt' || $antr === 'plh')
                    <p class="signature-details" style="margin-top: 0; margin-bottom: 80px;">
                    {{ $pejabat->jabatan_utama }}
                    </p>
                    @else
                    <p style="margin-bottom: 80px;"></p>
                    @endif

        
                    <h5 class="signature-name" style="margin-top: 80px;">{{ $pejabat->nama ?? '' }}</h5>
                    <div class="signature-line"></div>
                    <p class="signature-details" style="margin-top: 0; margin-bottom: 0;">{{ $pejabat->pangkat ?? '' }}</p>
                    <p class="signature-details" style="margin-top: 0;">NIP. {{ $pejabat->nip ?? '' }}</p>
                </div>
            </div>
        

            <div class="page-number">Halaman 1 dari 1</div>
        </div>
    </div>

    <script>
        // Mode Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleMode');
            const body = document.body;
            
            // Check for saved mode preference
            const savedMode = localStorage.getItem('mode');
            if (savedMode === 'dark') {
                body.classList.replace('light-mode', 'dark-mode');
                toggleButton.textContent = '☀ Mode Terang';
            }
            
            // Toggle between modes
            toggleButton.addEventListener('click', function() {
                if (body.classList.contains('light-mode')) {
                    body.classList.replace('light-mode', 'dark-mode');
                    toggleButton.textContent = '☀ Mode Terang';
                    localStorage.setItem('mode', 'dark');
                } else {
                    body.classList.replace('dark-mode', 'light-mode');
                    toggleButton.textContent = '🌓 Mode Gelap';
                    localStorage.setItem('mode', 'light');
                }
            });
            
            // Auto close after print if needed
            window.onafterprint = function() {
                // Uncomment below if you want to close after printing
                // window.close();
            };
        });
    </script>
</body>
</html>