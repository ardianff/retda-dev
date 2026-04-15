<?php


namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\Models\Npwpd;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;


class NpwpdExport implements FromView, ShouldAutoSize
{

    private $tahun;
    private $jenis;
    private $status;

    public function __construct($tahun,$jenis,$status)
    {
        $this->tahun = $tahun;
        $this->jenis = $jenis;
        $this->status = $status;
    }

    public function view(): View
    {
        $np=Npwpd::with('kota')->where('tahun',$this->tahun);
        if ($this->jenis !=0) {
            $np->where('jenis',$this->jenis);
        }
        if ($this->status !=0) {
            $np->where('status',$this->status);
        }
        $data=$np->orderBy('id', 'desc')->get();


        return view('npwpd.excel', compact('data'));
    }
}
