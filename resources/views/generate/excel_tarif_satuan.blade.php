<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Tarif Satuan</title>
    <style>
        @page { size: folio landscape; margin: 1.3cm 1.2cm 0.1cm 1.2cm; }
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid black; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
    </style>
</head>
<body>

<table>
    <thead>
        <tr style="background-color: #000; color: #fff;">
            <th>ID BAPENDA</th>
            <th>Penerimaan</th>
            <th>ID Level VI GRMS</th>
            <th>ID GRMS 2025</th>
            <th>Lok. GRMS</th>
            <th>Uraian</th>
            <th>ID Satuan</th>
            <th>Satuan</th>
            <th>Jasa Sarana</th>
            <th>Jasa Layanan</th>
            <th>Tarif</th>
            <th>Status</th>
            <th>Tarif PU</th>
        </tr>
    </thead>
    <tbody>
        @php
            function getFullUraian($item) {
                $uraian = [$item->uraian];
                $current = $item;
                while ($current->parent_id) {
                    $parent = $item->where('id', $current->parent_id)->first();
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

        <tr>
            <td>{{ $tarif->grms_id }}</td>
            <td>{{ $tarif->rekening->ket ?? '-' }}</td>
            <td>{{ $tarif->rekening->rek_grms ?? '-' }}</td>
            <td>{{ $tarif->rekening->grms_id_2025 ?? '-' }}</td>
            <td>{{ $tarif->uppd->id_grms ?? '-' }}</td>
            <td>{{ getFullUraian($tarif) }}</td>
            <td>{{ optional($tarif->satuan)->id ?? '0' }}</td>
            <td>{{ optional($tarif->satuan)->uraian ?? '-' }}</td>
            <td>{{ $tarif->tarif_sarana }}</td>
            <td>{{ $tarif->tarif_layanan }}</td>
            <td>{{ $tarif->nilai }}</td>
            <td>{{ $tarif->status }}</td>
            <td>{{ $tarif->format_tarif === 'up' ? 'Y' : 'T' }}</td>
        </tr>
    </tbody>
</table>

</body>
</html>
