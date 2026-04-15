<?php


namespace App\Exports;

use App\Models\Tarif;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class Generate implements FromQuery, WithMapping, WithHeadings, WithChunkReading
{
    protected $ta_id;
    protected $gol_id;
    protected $opd_id;
    protected $uppd_id;

    public function __construct($ta_id, $opd_id, $gol_id, $uppd_id)
    {
        $this->ta_id = $ta_id;
        $this->gol_id = $gol_id;
        $this->opd_id = $opd_id;
        $this->uppd_id = $uppd_id;
    }

   public function query()
{
    $query = Tarif::query()
        ->with(['rekening','satuan','uppd'])
        ->where('golongan_id', $this->gol_id)
        ->where('opd_id', $this->opd_id)
        ->where('ta_id', $this->ta_id)
        ->where('type','body')
        ->where('status', 1);

    if ($this->uppd_id != 0) {
        $query->where('uppd_id', $this->uppd_id);
    }

    return $query;
}

    public function headings(): array
    {
        return [
            'ID BAPENDA',
            'Penerimaan',
            'ID Level VI GRMS',
            'ID GRMS 2025',
            'Lok GRMS',
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
        return [
            $item->grms_id,
            $item->rekening->ket ?? '',
            $item->rekening->rek_grms ?? '',
            $item->rekening->grms_id_2025 ?? '',
            $item->uppd->id_grms ?? '',
            $item->uraian,
            $item->satuan->id ?? 0,
            $item->satuan->uraian ?? 0,
            $item->tarif_sarana,
            $item->tarif_layanan,
            $item->nilai,
            $item->status,
            $item->format_tarif == 'up' ? 'Y' : 'T',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}