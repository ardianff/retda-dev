<?php


namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\Models\Opd;
use App\Models\Golongan;
use App\Models\Uppd;
use App\Models\Jenis;
use App\Models\UsulanTarif;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;


class draft_excel implements FromView, ShouldAutoSize, WithStyles
{
    public $data;
    public $uppd;
    public $opd;
    public $golongan;

    public function __construct($golongan, $opd,$uppd,$data)
    {
        $this->data = $data;
        $this->opd = $opd;
        $this->uppd = $uppd;
        $this->golongan = $golongan;
    }

    public function view(): View
    {
        return view('print.draft.draft_excel', [
            'data' => $this->data,
            'uppd' => $this->uppd,
            'opd' => $this->opd,
            'golongan' => $this->golongan,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A:Z' => [ // Atur agar semua kolom A sampai Z wrap text
                'alignment' => [
                    'wrapText' => false,
                    'vertical' => Alignment::VERTICAL_TOP,
                ],
            ],
        ];
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();
            $highestRow = $sheet->getHighestRow();

            for ($row = 1; $row <= $highestRow; $row++) {
                $value = $sheet->getCell("A$row")->getValue();

                // Hanya non-wrap jika cell tidak kosong dan bukan kode angka (misalnya kode usulan)
                if (!empty($value) && !preg_match('/^[0-9]{2,}/', trim($value))) {
                    // Nonaktifkan wrap khusus untuk cell judul
                    $sheet->getStyle("A$row")->getAlignment()->setWrapText(false);
                }
            }
        }
    ];
}
}
