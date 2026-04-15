<?php

namespace App\Exports;


use App\Models\Jenis;
use App\Models\Uppd;
use Maatwebsite\Excel\Concerns\FromArray;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Borders;


class UsulanExcel implements FromArray, WithStyles, WithEvents
{
    protected $pengajuan_id;
    protected $gol_id;
    protected $opd_id;
    protected $upp_id;

    public function __construct($pengajuan_id, $gol_id, $opd_id, $uppd_id)
    {
        $this->pengajuan_id = $pengajuan_id;
        $this->gol_id = $gol_id;
        $this->opd_id = $opd_id;
        $this->uppd_id = $uppd_id;
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
    
                $range = 'A1:' . $highestColumn . $highestRow;
    
                // Terapkan border ke seluruh range data
                $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }
        ];
    }

    public function array(): array
    {
        $result = [];
        $this->borderRows = []; // untuk menyimpan baris yang akan diberi border bawah
        $rowIndex = 2; // mulai dari baris 2 karena heading di baris 1
    if ($this->uppd_id == 0) {
 
        $uppds = Uppd::where('opd_id', $this->opd_id)->orderBy('id_grms','ASC')->get();
    }else{
        $uppds = Uppd::where('id', $this->uppd_id)->orderBy('id_grms','ASC')->get();
    }
    
    foreach ($uppds as $uppd) {
        // Ambil semua jenis yang punya usulan aktif untuk UPPD ini
        $jenisList = Jenis::whereHas('usulan', function ($query) use ($uppd) {
                $query->where('uppd_id', $uppd->id)
                      ->where('tu_id', $this->pengajuan_id)
                      ->where('status', 1);
            })
            ->with(['usulan' => function ($query) use ($uppd) {
                $query->where('uppd_id', $uppd->id)
                      ->where('tu_id', $this->pengajuan_id)
                      ->where('status', 1)
                      ->where('parent_id', 0)
                      ->with(['children' => function ($q) {
                          $q->where('status', 1)
                            ->with(['children' => function ($q2) {
                                $q2->where('status', 1);
                            }]);
                      }]);
            }])
            ->get();

        if ($jenisList->isEmpty()) continue; // Skip UPPD tanpa jenis/usulan

        // Tambah header UPPD
        $result[] = [ $uppd->nama];
        $result[] = ['']; // spacer antara jenis dan tabel tarif
        $result[] = ['']; // spacer antara jenis dan tabel tarif
        // $result[] = ['No', 'Uraian', 'Satuan', 'Tarif Semula', 'Tarif Usulan', 'Presentase', 'Keterangan'];
        

        foreach ($jenisList as $jenis) {
            $result[] = [ $jenis->name];
             $result[] = [''];
            $result[] = ['No', 'Uraian', 'Satuan', 'Tarif Semula', 'Tarif Usulan', 'Presentase', 'Keterangan'];

            foreach ($jenis->usulan as $usulan) {
                $this->addUsulanRows($usulan, $result);
            }

            $result[] = ['']; // Spacer antar jenis
        }

        $result[] = [''];
    }

    return $result;
}

protected function addUsulanRows($usulan, &$result, $level = 0)
{
    $result[] = [
        $usulan->number,
        $usulan->uraian,
        $usulan->satuan?->uraian ?? '',
        $usulan->nilai ? number_format($usulan->nilai, 0, ',', '.') : '',
        $usulan->u_nilai ? number_format($usulan->u_nilai, 0, ',', '.') : '',
        $this->calculatePercentage($usulan),
        $this->getKeterangan($usulan)
    ];
    $this->borderRows[] = count($result);
    foreach ($usulan->children as $child) {
        $this->addUsulanRows($child, $result, $level + 1);
    }
}

protected function calculatePercentage($usulan)
{
    if ($usulan->bukan_nilai == 1) return '';
    return $usulan->nilai != 0 
        ? number_format((($usulan->u_nilai - $usulan->nilai) / $usulan->nilai) * 100, 2) . '%'
        : '0%';
}

protected function getKeterangan($usulan)
{
    if ($usulan->bukan_nilai == 1) return 'Tarif Bukan Rupiah';
    if ($usulan->nilai == 0 && $usulan->u_nilai > 0) return 'Usulan Baru';
    if ($usulan->u_nilai > $usulan->nilai) return 'Kenaikan Tarif';
    if ($usulan->u_nilai < $usulan->nilai) return 'Penurunan Tarif';
    return '';
}

public function styles(Worksheet $sheet)
{
    $styles = [];

    foreach ($this->borderRows as $row) {
        $styles[$row] = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
    }

    return $styles;
}




}
    