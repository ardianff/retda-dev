<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{$opd->singkatan}}_Lampiran_Tarif</title>
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
            border: 1px solid;

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
            <div class="pdf-title">{{$opd->singkatan}} Lampiran_Tarif</div>
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
                                    <th >No</th>
                                    <th >Uraian</th>
                                    <th >Satuan</th>

                                    @if ($jenis->id == 16)
                                    <th>Jasa Sarana</th>
                                    <th>Jasa Layanan</th>
                                    <th>Tarif (Rp)</th>
                                    @else
                                    <th>Tarif (Rp)</th>

                                    @endif

                                    <th >Keterangan</th>
                                </tr>

                              
                            </thead>
                            <tbody>
                            @foreach ($jenis->usulan->where('uppd_id', $b->id)->where('parent_id', 0)->where('status', 1) as $parent)
                                @include('print.lampiran.partialpdf', ['tarif' => $parent, 'level' => 0])
                            @endforeach
                               
                            </tbody>
                        </table>
                    @endforeach
                @endif
            @endforeach
            
        

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