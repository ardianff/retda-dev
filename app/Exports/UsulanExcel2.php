<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsulanExcel2 implements FromView

// class UsulanExcel implements FromArray, WithHeadings, WithMapping, WithStyles
{
    public $data;
    public $pejabat;
    public $uppd;
    public $opd;
    public $golongan;

    public function __construct($golongan, $opd,$uppd,$data,$pejabat)
    {
        $this->data = $data;
        $this->opd = $opd;
        $this->uppd = $uppd;
        $this->pejabat = $pejabat;
        $this->golongan = $golongan;
    }

    public function view(): View
    {
        return view('print.usulan.excel', [
            'data' => $this->data,
            'uppd' => $this->uppd,
            'opd' => $this->opd,
            'golongan' => $this->golongan,
            'pejabat' => $this->pejabat
        ]);
    }
}