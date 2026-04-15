<?php

namespace App\Exports;

use App\Models\UsulanTarif;
use App\Models\Jenis;
use App\Models\Uppd;
use App\Models\Opd;
use App\Models\Golongan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsulanGenerate implements FromQuery, WithHeadings, WithMapping, WithChunkReading, ShouldQueue
{
    protected $pengajuan_id;
    protected $id_opd;
    protected $id_uppd;
    protected $id_golongan;
    protected $filter;

    public function __construct($pengajuan_id, $id_opd, $id_golongan, $id_uppd, $filter)
    {
        $this->pengajuan_id = $pengajuan_id;
        $this->id_opd = $id_opd;
        $this->id_uppd = $id_uppd;
        $this->id_golongan = $id_golongan;
        $this->filter = $filter;
    }

 public function query()
{
    $query = UsulanTarif::query()
        ->with(['rekening','satuan','uppd','parent'])
        ->where('golongan_id', $this->id_golongan)
        ->where('opd_id', $this->id_opd)
        ->where('tu_id', $this->pengajuan_id)
        ->where('tipe','body')
        ->where('status', 1);

    if ($this->id_uppd != 0) {
        $query->where('uppd_id', $this->id_uppd);
    }

    // 🔥 FILTER LOGIC
    if ($this->filter == 1) {
        // Tarif lama saja, tidak boleh kosong / 0
        $query->where(function($q){
            $q->whereNotNull('nilai')
              ->where('nilai','!=','')
              ->where('nilai','!=',0);
        });
    }

    if ($this->filter == 3) {
        // Tarif baru saja
        $query->where(function($q){
            $q->whereNotNull('u_nilai')
              ->where('u_nilai','!=','')
              ->orWhere('u_sarana','>',0)
              ->orWhere('u_layanan','>',0);
        });
    }

    return $query->orderBy('jenis_id', 'asc');
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
    // default
    $nilai = '';
    $sarana = '';
    $layanan = '';

    // 🔥 FILTER 1: Tarif Lama
    if ($this->filter == 1) {
        $nilai   = $item->nilai;
        $sarana  = $item->tarif_sarana;
        $layanan = $item->tarif_layanan;
         $format_up = ($item->format_tarif == 'up') ? 'Y' : 'T';
    }

    // 🔥 FILTER 2: Gabungan
    elseif ($this->filter == 2) {
        if (!empty($item->nilai) && $item->nilai != 0) {
            // pakai tarif lama
            $nilai   = $item->nilai;
            $sarana  = $item->tarif_sarana;
            $layanan = $item->tarif_layanan;
                $format_up = ($item->format_tarif == 'up') ? 'Y' : 'T';
        } else {
            // pakai tarif baru
            $nilai   = $item->u_nilai;
            $sarana  = $item->u_sarana;
            $layanan = $item->u_layanan;
            $format_up = ($item->u_format == 'up') ? 'Y' : 'T';
        }
    }

    // 🔥 FILTER 3: Tarif Usulan
    elseif ($this->filter == 3) {
        $nilai   = $item->u_nilai;
        $sarana  = $item->u_sarana;
        $layanan = $item->u_layanan;
        $format_up = ($item->u_format == 'up') ? 'Y' : 'T';
    }

    return [
        $item->grms_id,
        $item->rekening->ket ?? '',
        $item->rekening->grms_id_2025 ?? '',
        $item->uppd->id_grms ?? '',
        $this->getFullUraian($item),
        $item->satuan->id ?? 0,
        $item->satuan->uraian ?? 0,
        $sarana,
        $layanan,
        $nilai,
        $item->status,
        $format_up,
    ];
}
   protected function getFullUraian($item)
{
    $uraian = [];
    $current = $item;
    $limit = 10;

    while ($current && $limit--) {
        array_unshift($uraian, $current->uraian);
        $current = $current->parent;
    }

    return implode(' -> ', $uraian);
}

    public function chunkSize(): int
    {
        return 10000; // baca data per 1000 baris
    }
}
