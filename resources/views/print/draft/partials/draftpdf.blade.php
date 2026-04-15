
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
    <td>{{ $tarif->number }}</td>
    <td style="padding-left: 5px;">
       {{ $tarif->uraian }}
    </td>
    <td style="text-align: center;">{{ $tarif->satuan?->uraian ?? '' }}</td>
    @if ($tarif->jenis_id == 16)
    <td style="text-align:right">{{ $tarif->u_sarana != 0 ? number_format($tarif->u_sarana, 0, ',', '.') : '' }}@if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif</td>
    <td style="text-align:right">{{ $tarif->u_layanan != 0 ? number_format($tarif->u_layanan, 0, ',', '.') : '' }}@if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif</td>
    <td style="text-align:right">
        {{ $tarif->u_nilai !== null && $tarif->u_nilai != 0 ? number_format((float) $tarif->u_nilai, 0, ',', '.') : '' }}@if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif
    </td>
    
      
    @else
    <td style="text-align:right">
        {{ $tarif->u_nilai !== null && $tarif->u_nilai != 0 ? number_format((float) $tarif->u_nilai, 0, ',', '.') : '' }}@if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif
    </td>
    

        
    @endif
    <td>{{ isset($tarif->keterangan) ? $tarif->keterangan : '' }}
    </td>
</tr>

@if ($tarif->children->count() > 0)
    @foreach ($tarif->children as $child)
        @include('print.draft.partials.draftpdf', ['tarif' => $child])
    @endforeach
@endif
@endif
