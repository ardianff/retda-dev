<?php

namespace App\Exports;

use App\Models\Tarif;
use App\Models\Jenis;
use App\Models\Uppd;
use App\Models\Opd;
use App\Models\Golongan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TarifCsvExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    protected $ta_id;
    protected $opd_id;
    protected $gol_id;

    public function __construct($ta_id, $opd_id, $gol_id)
    {
        $this->ta_id = $ta_id;
        $this->opd_id = $opd_id;
        $this->gol_id = $gol_id;
    }

    public function query()
    {
        return Tarif::query()
            ->with(['rekening', 'uppd', 'satuan','parent'])
            ->where('ta_id', $this->ta_id)
            ->where('status', 1)
            ->where(function ($q) {
        $q->where('nilai', '!=', 0)
          ->orWhere('format_tarif', 'up');
    })
            ->orderBy('uppd_id')
            ->orderBy('number');
    }

    public function headings(): array
    {
        return [
            'ID BAPENDA',
            'Penerimaan',
            'ID Level VI GRMS',
            'Lok. GRMS',
            'Uraian',
            'ID Satuan',
            'Satuan',
            'Jasa Sarana',
            'Jasa Layanan',
            'Tarif',
            'Status',
            'Tarif PU'
        ];
    }

    public function map($item): array
    {
        // Mengambil uraian full dari parent
        $uraian = $this->getFullUraian($item);

        return [
            $item->grms_id,
            optional($item->rekening)->ket,
            optional($item->rekening)->rek_grms,
            optional($item->uppd)->id_grms,
            $uraian,
            optional($item->satuan)->id ?? 0,
            optional($item->satuan)->uraian ?? '',
            $item->tarif_sarana,
            $item->tarif_layanan,
            $item->nilai,
            $item->status,
            $item->format_tarif == 'up' ? 'Y' : 'T',
        ];
    }

    protected function getFullUraian($item)
    {
        $uraian = [$item->uraian];
        $current = $item;

        while ($current->parent_id) {
            $parent = Tarif::find($current->parent_id);
            if ($parent) {
                $uraian[] = $parent->uraian;
                $current = $parent;
            } else {
                break;
            }
        }

        return implode(' -> ', array_reverse($uraian));
    }

    public function chunkSize(): int
    {
        return 1000; // baca data per 1000 baris
    }
}
