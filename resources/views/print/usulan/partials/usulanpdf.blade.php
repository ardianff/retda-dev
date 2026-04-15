


@php
   $presentase = '';
$warna = '';
$penjelasan = '';

// 1. Perubahan Format Tarif
if ($tarif->format_tarif !== $tarif->u_format && $tarif->format_tarif !== null && $tarif->u_format !== null) {
    $presentase = 100;
    $warna = 'background-color: #618761; color: #05f29b;';
    $penjelasan = 'Perubahan Format Tarif';

// 2. Usulan Baru
} elseif (
    ($tarif->nilai == 0 && $tarif->u_nilai > 0) || 
    (is_null($tarif->format_tarif) && $tarif->u_format === 'rupiah' && $tarif->u_nilai > 0)
) {
    $presentase = 100;
    $warna = 'background-color: #618761; color: #05f29b;';
    $penjelasan = 'Usulan Baru';

// 3. Kenaikan / Penurunan Tarif
} elseif (
    $tarif->format_tarif === 'rupiah' && 
    $tarif->u_format === 'rupiah' && 
    $tarif->nilai != 0
) {
    $presentase = (($tarif->u_nilai - $tarif->nilai) / $tarif->nilai) * 100;

    if ($tarif->u_nilai > $tarif->nilai) {
        $warna = 'background-color: #618761; color: #19f011;';
        $penjelasan = 'Kenaikan Tarif';
    } elseif ($tarif->u_nilai < $tarif->nilai) {
        $warna = 'background-color: #a34545; color: #721c24;';
        $penjelasan = 'Penurunan Tarif';
    }

// 4. Header
} elseif ($tarif->tipe === 'header') {
    $presentase = '';
    $warna = '';
    $penjelasan = '';

// 5. Default
} else {
    $presentase = '';
    $warna = '';
    $penjelasan = '';
}

    // Format nilai
    $formattedNilai = $tarif->nilai != 0 ? number_format($tarif->nilai, 0, ',', '.') : '';
    $formattedUNilai = $tarif->u_nilai != 0 ? number_format($tarif->u_nilai, 0, ',', '.') : '';
@endphp
@if ($tarif->status == 1) <!-- Pastikan hanya tarif aktif -->
<tr style="border: 1px solid #000;">
    <td style="border: 1px solid #000;"><strong>{{ $tarif->number }}</strong></td>
    <td style="padding-left: 5px; border: 1px solid #000;">
        {{ $tarif->uraian }}
    </td>
    <td style="border: 1px solid #000;">{{ $tarif->satuan?->uraian ?? '' }}</td>
    @if ($tarif->jenis_id == 16)
    <td style="border: 1px solid #000;">{{ $tarif->tarif_sarana != 0 ? number_format($tarif->tarif_sarana, 0, ',', '.') : '' }}@if ($tarif->format_tarif == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif</td>
    <td style="border: 1px solid #000;">{{ $tarif->tarif_layanan != 0 ? number_format($tarif->tarif_layanan, 0, ',', '.') : '' }}@if ($tarif->format_tarif == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif</td>
    <td style="text-align:right;border: 1px solid #000;">
        {{ $tarif->nilai !== null && $tarif->nilai != 0 ? number_format((float) $tarif->nilai, 0, ',', '.') : '' }}@if ($tarif->format_tarif == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif
    </td>
    <td style="text-align:right;border: 1px solid #000;">{{ $tarif->u_sarana != 0 ? number_format($tarif->u_sarana, 0, ',', '.') : '' }}@if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif</td>
    <td style="text-align:right;border: 1px solid #000;">{{ $tarif->u_layanan != 0 ? number_format($tarif->u_layanan, 0, ',', '.') : '' }}@if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif</td>
    <td style="text-align:right;border: 1px solid #000;">
        {{ $tarif->u_nilai !== null && $tarif->u_nilai != 0 ? number_format((float) $tarif->u_nilai, 0, ',', '.') : '' }}@if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif
    </td>
        
    @else
    <td style="text-align:right;border: 1px solid #000;">
        {{ $tarif->nilai !== null && $tarif->nilai != 0 ? number_format((float) $tarif->nilai, 0, ',', '.') : '' }}@if ($tarif->format_tarif == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif
    </td>
    <td style="text-align:right;border: 1px solid #000;">
        {{ $tarif->u_nilai !== null && $tarif->u_nilai != 0 ? number_format((float) $tarif->u_nilai, 0, ',', '.') : '' }}@if ($tarif->u_format == 'bukan_rupiah')
        {{$tarif->bkn_nilai}}
    @endif
    </td>
        
    @endif
    <td style="{{ $warna }};border: 1px solid #000;">{{ $presentase !== '' ? number_format($presentase, 2, ',', '.') . '%' : '' }}</td>
    <td style="text-align:center;border: 1px solid #000;">{{ $tarif->keterangan ?? '-' }} </td>
    <td style="text-align:center;border: 1px solid #000;">{{ $tarif->penjelasan ?? '-'}}</td>
</tr>

    @if ($tarif->children->where('status', 1)->count() > 0)
        @foreach ($tarif->children->where('status', 1) as $child)
            @include('print.usulan.partials.usulanpdf', ['tarif' => $child])
        @endforeach
    @endif
@endif


{{-- @if ($tarif->children->count() > 0)
    @foreach ($tarif->children as $child)
        @include('print.usulan.partials.usulanpdf', ['tarif' => $child])
    @endforeach
@endif --}}
