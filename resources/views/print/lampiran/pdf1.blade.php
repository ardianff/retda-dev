<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lampiran Pergub Tarif</title>
    <style>
        @page { 
            size: folio Portrait; 
            margin: 1.1cm 0.7cm 0.8cm 1.8cm;
        }
    
        body { 
            font-family: Arial, sans-serif; 
            font-size: 13px; 
        }
    
        table { 
            width: 100%; 
            border-collapse: collapse; 
            /* margin-bottom: 2px;  */
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
            position: fixed; 
            bottom: 1px; 
            width: 100%; 
            text-align: center; 
            font-size: 5px; 
        }
    </style>
    
</head>
<body>
    {{-- <h2 align="center">Lampiran Pergub Tarif {{$ta->peraturan}}</h2> --}}

   
    @foreach ($uppd as $b)
    @php
        $jenisTersedia = $data->filter(function ($jenis) use ($b) {
            return $jenis->tarif->where('uppd_id', $b->id)->count() > 0;
        });
    @endphp

    @if ($jenisTersedia->count() > 0)
        <h2>{{ $b->nama }}</h2>

        @foreach ($jenisTersedia as $jenis)
            <h3> {{ $jenis->name }}</h3>
           
            <table class="table">
                <thead >
                    <tr >
                        <th class="" >Kode</th>
                        <th >Uraian</th>
                        <th >Satuan</th>
                        @if ($jenis->id == 16)
                        
                        <th>Jasa Sarana</th>
                        <th>Jasa Layanan</th>
                        <th>Tarif </th>
                    
                    @else
                        <th>Tarif</th>
                        
                    @endif
                        <th  >Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jenis->tarif->where('uppd_id', $b->id)->where('parent_id','=',0) as $parent)
                        @include('print.lampiran.partialpdf', ['tarif' => $parent])
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
@endforeach
<div class="footer">
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, sans-serif", "normal");
                $size = 10;
                $pageText =  $PAGE_NUM ;
                $y = 910; // Sesuaikan posisi vertikal
                $x = 290; // Sesuaikan posisi horizontal agar di tengah
                $pdf->text($x, $y, $pageText, $font, $size);
            ');
        }
    </script>
</div>   
</body>
</html>
