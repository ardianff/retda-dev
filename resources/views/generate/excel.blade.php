<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Generate Tarif</title>
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
    @php
    function getFullUraian($item, $allTarifs) {
        $uraian = [$item->uraian];
        $current = $item;
        while ($current->parent_id) {
            $parent = $allTarifs->firstWhere('id', $current->parent_id);
            if ($parent) {
                $uraian[] = $parent->uraian;
                $current = $parent;
            } else {
                break;
            }
        }
        return implode(' -> ', array_reverse($uraian));
    }
    @endphp
    
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
          

            <tr style="background-color: #000; font-weight: bold;">
                <th style="border: 1px solid #000;" >ID BAPENDA</th>
                <th style="border: 1px solid #000;" >Penerimaan</th>
                <th style="border: 1px solid #000;" >ID Level VI GRMS</th>
                <th style="border: 1px solid #000;" >ID GRMS 2025</th>
                <th style="border: 1px solid #000;" >Lok. GRMS</th>
                <th style="border: 1px solid #000;" >Uraian</th>
                <th style="border: 1px solid #000;" >ID Satuan</th>
                <th style="border: 1px solid #000;" >Satuan</th>

               <th style="border: 1px solid #000;" >Jasa Sarana</th>
                <th style="border: 1px solid #000;" >Jasa layanan</th>
              
                <th style="border: 1px solid #000;" >Tarif</th>
                
                <th style="border: 1px solid #000;" >Status</th>
                <th style="border: 1px solid #000;" >Tarif PU</th>
            </tr>

          
        </thead>
    {{-- Isi Utama --}}
    @foreach ($uppd as $b)
    @php
        $jenisTersedia = $data->filter(function ($jenis) use ($b) {
            return $jenis->tarif->where('uppd_id', $b->id)->count() > 0;
        });
    @endphp

    @if ($jenisTersedia->count() > 0)

        @foreach ($jenisTersedia as $jenis)

               
                    <tbody>
                        @foreach ($jenis->tarif->where('uppd_id', $b->id)->where('tipe', 'body') as $item)
                       
                        <tr style="border: 1px solid #000;">
                            <td style="border: 1px solid #000;">{{$item->grms_id}}</td>
                            <td style="border: 1px solid #000;">{{$item->rekening->ket}}</td>
                            <td style="border: 1px solid #000;">{{$item->rekening->rek_grms}}</td>
                            <td style="border: 1px solid #000;">{{$item->rekening->grms_id_2025}}</td>
                            <td style="border: 1px solid #000;">{{$item->uppd->id_grms}}</td>
                            <td style="border: 1px solid #000;">{{ getFullUraian($item, $jenis->tarif) }}</td> {{-- Ini yang dirubah --}}
                            <td style="border: 1px solid #000;">{{$item->satuan->id??0}}</td>
                            <td style="border: 1px solid #000;">{{$item->satuan->uraian??0}}</td>
                           <td style="border: 1px solid #000;">{{$item->tarif_sarana}}</td>
                            <td style="border: 1px solid #000;">{{$item->tarif_layanan}}</td>
                            <td style="border: 1px solid #000;">{{$item->nilai}}</td>
                            <td style="border: 1px solid #000;">{{$item->status}}</td>
                            <td style="border: 1px solid #000;">{{($item->format_tarif == 'up' ? 'Y': 'T')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                    
                    
                    @endforeach
                    @endif
                    @endforeach
                </table>
   
</body>
</html>
