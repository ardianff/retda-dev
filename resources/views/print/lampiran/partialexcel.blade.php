
@php
    // $nilai = '';
    // if ($tarif->bukan_nilai == 1) {
    //     $nilai = $tarif->nilai;
    // } elseif ($tarif->up != 0) {
    //     $nilai = $tarif->nilai;
    // } elseif ($tarif->nilai != 0) {
    //     $nilai = number_format($tarif->nilai, 0, ',', '.');
    // }else {
    //     $nilai='';
    // }
@endphp
@if ($tarif->status == 1)

<tr >
    <td style="text-align: left; border: 1px solid black">{{ $tarif->number }}</td>
    <td style="padding-left: 5px;text-align: left; border: 1px solid black">
       {{ $tarif->uraian }}
    </td>
    <td style="text-align: center; border: 1px solid black;">{{ $tarif->satuan?->uraian ?? '' }}</td>
    @if ($tarif->jenis_id == 16)
    <td style="text-align:right;border: 1px solid black">
        @if ($tarif->tipe=='body'){{ $tarif->tarif_sarana }} @endif
       @if ($tarif->format_tarif == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif</td>
    <td style="text-align:right;border: 1px solid black">@if ($tarif->tipe=='body'){{ $tarif->tarif_layanan }}@endif
        @if ($tarif->format_tarif == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif</td>
    <td style="text-align:right;border: 1px solid black">
        @if ($tarif->tipe=='body') {{ $tarif->nilai  }}@endif
        @if ($tarif->format_tarif == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif
    </td>
    
      
    @else
    <td style="text-align:right;border: 1px solid black">
        @if ($tarif->tipe=='body') {{ $tarif->nilai }}@endif
        @if ($tarif->format_tarif == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif
    </td>
    

        
    @endif
    <td style="text-align:left;border: 1px solid black">{{ isset($tarif->keterangan) ? $tarif->keterangan : '' }}
    </td>
</tr>

@if ($tarif->children->count() > 0)
    @foreach ($tarif->children as $child)
        @include('print.lampiran.partialexcel', ['tarif' => $child])
    @endforeach
@endif
@endif
