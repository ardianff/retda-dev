<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class TarifSatuanExport implements FromView
{
    protected $tarif;

    public function __construct($tarif)
    {
        $this->tarif = $tarif;
    }

    public function view(): View
    {
        return view('generate.excel_tarif_satuan', [
            'tarif' => $this->tarif
        ]);
    }
}

