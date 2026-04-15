<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Usulan Tarif</title>
    <style>
     

        table { 
            width: 100%; 
            border-collapse: collapse;
        }

        td{ 
            border: 1px solid black; 
          
        }

       
        
    </style>
</head>
<body>
<h2>Rekap {{$tu->deskripsi}}</h2>
    <h3>OPD : {{$opd->opd}}</h3>
    <h3> UPPD/Balai/UPT : {{$uppd->nama}}</h3>

    <table>
        <tr>
            <td>Jumlah Kenaikan Tarif :</td>
            <td>{{$jumlah_kenaikan}}</td>
        </tr>
        <tr>
            <td>Jumlah Penurunan Tarif :</td>
            <td>{{$jumlah_penurunan}}</td>
        </tr>
        <tr>
            <td>Jumlah Usulan Tarif Baru :</td>
            <td>{{$jumlah_usulan_baru}}</td>
        </tr>
        <tr>
            <td>Jumlah  Tarif tetap :</td>
            <td>{{$jumlah_tetap}}</td>
        </tr>
        @if ($jumlah_perubahan_format != 0)
            
        <tr>
            <td>Jumlah  Perubahan Format Tarif :</td>
            <td>{{$jumlah_perubahan_format}}</td>
        </tr>
        @endif
        
        <tr style="margin-bottom: 30px">
            <td>Jumlah  Keseluruhan Tarif :</td>
            <td>{{$keseluruhan}}</td>
        </tr>
        <tr>
            <td>Jumlah  Tarif Dihapus :</td>
            <td>{{$nonAktif}}</td>
        </tr>
    </table>
</body>
</html>