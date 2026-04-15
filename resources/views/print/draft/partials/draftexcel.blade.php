
@php
    // $u_nilai = '';
    // if ($tarif->bukan_nilai == 1) {
    //     $u_nilai = $tarif->u_nilai;
    // } elseif ($tarif->up != 0) {
    //     $u_nilai = $tarif->u_nilai;
    // } elseif ($tarif->u_nilai != 0) {
    //     $u_nilai = number_format($tarif->u_nilai, 0, ',', '.');
    // }else {
    //     $u_nilai='';
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
        @if ($tarif->tipe=='body'){{ $tarif->u_sarana }} @endif
       @if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif</td>
    <td style="text-align:right;border: 1px solid black">@if ($tarif->tipe=='body'){{ $tarif->u_layanan }}@endif
        @if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif</td>
    <td style="text-align:right;border: 1px solid black">
        @if ($tarif->tipe=='body') {{ $tarif->u_nilai  }}@endif
        @if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif
    </td>
    
      
    @else
    <td style="text-align:right;border: 1px solid black">
        @if ($tarif->tipe=='body') {{ $tarif->u_nilai }}@endif
        @if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif
    </td>
    

        
    @endif
    <td style="text-align:left;border: 1px solid black">{{ isset($tarif->keterangan) ? $tarif->keterangan : '' }}
    </td>
</tr>

@if ($tarif->children->count() > 0)
    @foreach ($tarif->children as $child)
        @include('print.draft.partials.draftexcel', ['tarif' => $child])
    @endforeach
@endif
@endif
