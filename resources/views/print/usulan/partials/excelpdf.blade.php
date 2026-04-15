
@php
   $presentase = '';
$warna = '';
$keterangan = '';

// 1. Perubahan Format Tarif
if ($tarif->format_tarif !== $tarif->u_format && $tarif->format_tarif !== null && $tarif->u_format !== null) {
    $presentase = 100;
    $warna = 'background-color: #618761; color: #05f29b;';
    $keterangan = 'Perubahan Format Tarif';

// 2. Usulan Baru
} elseif (
    ($tarif->nilai == 0 && $tarif->u_nilai > 0) || 
    (is_null($tarif->format_tarif) && $tarif->u_format === 'rupiah' && $tarif->u_nilai > 0)
) {
    $presentase = 100;
    $warna = 'background-color: #618761; color: #05f29b;';
    $keterangan = 'Usulan Baru';

// 3. Kenaikan / Penurunan Tarif
} elseif (
    $tarif->format_tarif === 'rupiah' && 
    $tarif->u_format === 'rupiah' && 
    $tarif->nilai != 0
) {
    $presentase = (($tarif->u_nilai - $tarif->nilai) / $tarif->nilai) * 100;

    if ($tarif->u_nilai > $tarif->nilai) {
        $warna = 'background-color: #618761; color: #19f011;';
        $keterangan = 'Kenaikan Tarif';
    } elseif ($tarif->u_nilai < $tarif->nilai) {
        $warna = 'background-color: #a34545; color: #721c24;';
        $keterangan = 'Penurunan Tarif';
    }

// 4. Header
} elseif ($tarif->tipe === 'header') {
    $presentase = '';
    $warna = '';
    $keterangan = '';

// 5. Default
} else {
    $presentase = '';
    $warna = '';
    $keterangan = '';
}

    // Format nilai
   
@endphp
@if ($tarif->status == 1) <!-- Pastikan hanya tarif aktif -->
<tr style="border: 1px solid #000;">
    <td style="border: 1px solid #000;"><strong>{{ $tarif->number }}</strong></td>
    <td style="padding-left: 5px; border: 1px solid #000;">
        {{ $tarif->uraian }}
    </td>
    <td style="border: 1px solid #000;">{{ $tarif->satuan?->uraian ?? '' }}</td>
    @if ($tarif->jenis_id == 16)
    <td style="border: 1px solid #000;">
        @if ($tarif->tipe == 'body'){{ $tarif->tarif_sarana }}@endif 
        @if ($tarif->format_tarif == 'bukan_rupiah'){{$tarif->bkn_nilai}} @endif
    </td>
    <td style="border: 1px solid #000;">
        @if ($tarif->tipe == 'body'){{ $tarif->tarif_layanan  }}@endif 
        @if ($tarif->format_tarif == 'bukan_rupiah'){{$tarif->bkn_nilai}}@endif
    </td>
    <td style="text-align:right;border: 1px solid #000;">
        @if ($tarif->tipe == 'body'){{ $tarif->nilai }} @endif 
        @if ($tarif->format_tarif == 'bukan_rupiah') {{$tarif->bkn_nilai}}@endif
    </td>
    <td style="text-align:right;border: 1px solid #000;">
        @if ($tarif->tipe == 'body'){{ $tarif->u_sarana }}@endif
        @if ($tarif->u_format == 'bukan_rupiah') {{$tarif->bkn_nilai}} @endif
</td>
    <td style="text-align:right;border: 1px solid #000;">
        @if ($tarif->tipe == 'body') {{ $tarif->u_layanan  }}@endif
        @if ($tarif->u_format == 'bukan_rupiah') {{$tarif->bkn_nilai}} @endif
</td>
    <td style="text-align:right;border: 1px solid #000;">
        @if ($tarif->tipe == 'body'){{ $tarif->u_nilai   }}@endif
        @if ($tarif->u_format == 'bukan_rupiah') {{$tarif->bkn_nilai}} @endif
    </td>
        
    @else
    <td style="text-align:right;border: 1px solid #000;">
        @if ($tarif->tipe == 'body'){{ $tarif->nilai }}@endif
        @if ($tarif->format_tarif == 'bukan_rupiah') {{$tarif->bkn_nilai}} @endif
    </td>
    <td style="text-align:right;border: 1px solid #000;">
        @if ($tarif->tipe == 'body') {{ $tarif->u_nilai }} @endif
        @if ($tarif->u_format == 'bukan_rupiah'){{$tarif->bkn_nilai}}  @endif
    </td>
        
    @endif
    <td style="{{ $warna }};border: 1px solid #000;">{{ $presentase !== '' ? number_format($presentase, 2, '.', ',') . '%' : '' }}</td>
    <td style="text-align:center;border: 1px solid #000;">{{ $tarif->keterangan ?? '' }}</td>
    <td style="text-align:center;border: 1px solid #000;">{{ $tarif->penjelasan ?? '' }}</td>
</tr>

    @if ($tarif->children->where('status', 1)->count() > 0)
        @foreach ($tarif->children->where('status', 1) as $child)
            @include('print.usulan.partials.excelpdf', ['tarif' => $child])
        @endforeach
    @endif
@endif


{{-- @if ($tarif->children->count() > 0)
    @foreach ($tarif->children as $child)
        @include('print.usulan.partials.usulanpdf', ['tarif' => $child])
    @endforeach
@endif --}}
