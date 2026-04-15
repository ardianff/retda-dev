<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tarif Usulan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        td { border: 1px solid black; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center;border: 1px solid black; padding: 5px;}
        .section-title { font-size: 14px; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <h2 align="center">Draft Usulan Tarif </h2>

   
    @foreach ($uppd as $b)
    @php
        $jenisTersedia = $data->filter(function ($jenis) use ($b) {
            return $jenis->usulan->where('uppd_id', $b->id)->count() > 0;
        });
    @endphp

    @if ($jenisTersedia->count() > 0)
        <h2>{{ $b->nama }}</h2>
<br>
        @foreach ($jenisTersedia as $jenis)
            <h3 style="white-space: nowrap"> {{ $jenis->name }}</h3>
           <br>
            <table class="table">
                <thead >
                    <tr >
                        <th style="text-align: center;font-weight: bold; border: 1px solid black;width:100px" >Kode</th>
                        <th style="text-align: center;font-weight: bold; border: 1px solid black" >Uraian</th>
                        <th style="text-align: center;font-weight: bold; border: 1px solid black;width:100px" >Satuan</th>
                        @if ($jenis->id == 16)
                            
                        <th style="text-align: center;font-weight: bold; border: 1px solid black;width:100px">Jasa Sarana</th>
                        <th style="text-align: center;font-weight: bold; border: 1px solid black;width:100px">Jasa Layanan</th>
                        @endif
                        <th  style="text-align: center;font-weight: bold; border: 1px solid black;width:100px">Tarif</th>
                        <th  style="text-align: center;font-weight: bold; border: 1px solid black">Keterangan</th>
                    </tr>
                    
                </thead>
                <tbody>
                    @foreach ($jenis->usulan->where('uppd_id', $b->id)->where('parent_id','=',0) as $parent)
                        @include('print.draft.partials.draftexcel', ['tarif' => $parent, 'level' => 0])
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
@endforeach
          
</body>
</html>
