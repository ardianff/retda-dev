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

        body { 
            font-family: Arial, sans-serif; 
            font-size: 13px; 
            margin: 0;
        }

        table { 
            width: 100%; 
            border-collapse: collapse;
        }

        td, th { 
            border: 1px solid black; 
            padding: 5px; 
            text-align: left; 
        }

        th { 
            background-color: #f2f2f2; 
            text-align: center; 
        }

        .footer { 
            text-align: center; 
            font-size: 10px; 
            margin-top: 20px;
        }

        .no-print {
            margin: 10px;
            text-align: right;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            @page {
                size: folio landscape;
                margin: 1.3cm 1.2cm 0.1cm 1.2cm;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    {{-- Tombol Cetak --}}


    {{-- Isi Utama --}}
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

                <table border="1" cellspacing="0" cellpadding="5">
                    <thead>
                        <tr style="background-color: #000; font-weight: bold;">
                            <th style="border: 1px solid #000;" rowspan="2">No urut</th>
                            <th style="border: 1px solid #000;" rowspan="2">Uraian</th>
                            <th style="border: 1px solid #000;" rowspan="2">Satuan</th>

                            @if ($jenis->id == 16)
                                <th style="border: 1px solid #000;" colspan="3">Tarif Semula</th>
                                <th style="border: 1px solid #000;" colspan="3">Tarif Menjadi</th>
                            @else
                                <th style="border: 1px solid #000;" colspan="2">Tarif</th>
                            @endif

                            <th style="border: 1px solid #000;" rowspan="2">%</th>
                            <th style="border: 1px solid #000;" rowspan="2">Keterangan</th>
                            <th style="border: 1px solid #000;" rowspan="2">Penjelasan</th>
                        </tr>

                        @if ($jenis->id == 16)
                            <tr style="border: 1px solid #000;">
                                <th style="border: 1px solid #000;">Jasa Sarana</th>
                                <th style="border: 1px solid #000;">Jasa Layanan</th>
                                <th style="border: 1px solid #000;">Tarif</th>
                                <th style="border: 1px solid #000;">Jasa Sarana</th>
                                <th style="border: 1px solid #000;">Jasa Layanan</th>
                                <th style="border: 1px solid #000;">Tarif</th>
                            </tr>
                        @else
                            <tr style="border: 1px solid #000;">
                                <th style="border: 1px solid #000;">Semula</th>
                                <th style="border: 1px solid #000;">Usulan</th>
                            </tr>
                        @endif
                    </thead>
                    <tbody>
                        @foreach ($jenis->usulan->where('uppd_id', $b->id)->where('parent_id', 0) as $parent)
                            @include('print.usulan.partials.excelpdf', ['tarif' => $parent, 'level' => 0])
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endif
    @endforeach

    {{-- Tanda Tangan --}}
    <div style="text-align: right; margin-right: 50px; margin-top: 50px;">
        <div style="display: inline-block; text-align: center;">
            <p style="margin-bottom: 0px;">{{$pejabat->kota}}, {{ tanggal_indonesia(date('Y-m-d')) }}</p>
            <p style="margin-top: 3px;">{{ ($pejabat->antr_waktu ?? '') !== 'none' ? $pejabat->antr_waktu . ' ' : '' }}{{ $pejabat->jabatan ?? '' }}</p>
            <p style="margin-top: 0; margin-bottom: 100px;">{{ $pejabat->jabatan_utama ?? '' }}</p>

            <div style="width: fit-content; min-width: 10px; margin: 0 auto;">
                <h3 style="margin: 0;">{{ $pejabat->nama ?? '' }}</h3>
                <div style="border-top: 1px solid black; margin-top: 5px;"></div>
            </div>

            <p style="margin-top: 5px; margin-bottom: 0;">{{ $pejabat->pangkat ?? '' }}</p>
            <p style="margin-top: 0;">NIP. {{ $pejabat->nip ?? '' }}</p>
        </div>
    </div>

</body>
</html>
