<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Golongan;
use App\Models\Jenis;
use App\Models\Opd;
use App\Models\Satuan;
use App\Models\Rekening;
use App\Models\Pengajuan;
use App\Models\Uppd;
use App\Models\TahunUsulan;
use App\Models\TA;
use App\Models\Tarif;
use App\Exports\Generate;
use App\Exports\TarifSatuanExport;
use App\Exports\TarifCsvExport;
use App\Exports\UsulanTarifCsvExport;
use App\Exports\UsulanGenerate;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;


class GenerateController extends Controller
{
    
  public function index()
    {
        $golongan=Golongan::all();
        $opd=Opd::where('status','Aktif')->get();
        $uppd=Uppd::where('status','Aktif')->get();
        $ta=TA::orderBy('id','DESC')->get();
        $pengajuan=TahunUsulan::where('status',1)->get();

         return view('generate.index',compact('golongan','opd','ta','uppd','pengajuan'));
    }


    function print(Request $request) 
    {
        // return $request;
        $ta_id = $request->ta_id;
        $opd_id       = $request->opd_id;
        $uppd_id      = $request->uppd_id;
        $gol_id       = $request->gol_id;
        
        // Cari pejabat berdasarkan kondisi uppd_id
     
        // return $pejabat;
        // Lanjut kalau pejabat ditemukan
    
           if ($request->action == 'pdf') {
                return $this->PDF($ta_id, $opd_id, $gol_id, $uppd_id);
            } elseif ($request->action == 'excel') {
                return $this->Excel($ta_id, $opd_id, $gol_id, $uppd_id);
        
        }elseif ($request->action == 'csv') {
                return $this->csv($ta_id, $opd_id, $gol_id, $uppd_id);
        
        }else{
            // Kalau pejabat tidak ditemukan
            return redirect()->back()->with('message', [
                'type' => 'danger',
                'text' => 'action tidak jelas'
            ]);
        }
        
    }
    function usulan(Request $request) 
    {
        $pengajuan_id = $request->pengajuan_id;
        $id_opd       = $request->id_opd;
        $id_uppd      = $request->id_uppd;
        $id_golongan       = $request->id_golongan;
        $filter       = $request->filter;
        
        // Cari pejabat berdasarkan kondisi uppd_id
     
        // return $pejabat;
        // Lanjut kalau pejabat ditemukan
    
           if ($request->aksi == 'pdf') {
                return $this->usulanPDF($pengajuan_id, $id_opd, $id_golongan, $id_uppd, $filter);
            } elseif ($request->aksi == 'excel') {
                return $this->usulanExcel($pengajuan_id, $id_opd, $id_golongan, $id_uppd, $filter);
        
        }elseif ($request->aksi == 'csv') {
                return $this->usulanCsv($pengajuan_id, $id_opd, $id_golongan, $id_uppd, $filter);
        
        }else{
            // Kalau pejabat tidak ditemukan
            return redirect()->back()->with('message', [
                'type' => 'danger',
                'text' => 'action tidak jelas'
            ]);
        }
        
    }

    public function tarif($id)
    {
       

        $tarif = Tarif::with(['rekening', 'satuan', 'uppd'])->findOrFail($id);

return Excel::download(new TarifSatuanExport($tarif), 'Tarif_'.$tarif->id.'.xlsx');

       }

    private function Excel($ta_id, $opd_id, $gol_id, $uppd_id) 
    {
        
    //     ini_set('max_execution_time', 600);
        $opd=Opd::find($opd_id);
        $golongan=Golongan::find($gol_id);
        if ($uppd_id == 0) {
     
            $uppd = Uppd::where('opd_id',$opd_id)->orderBy('id_grms','ASC')->get();
            $uppd_name='Keseluruhan';
        }else{
            $uppd = Uppd::where('id',$uppd_id)->orderBy('id_grms','ASC')->get();
            $uptd=Uppd::find($uppd_id);
            $uppd_name=$uptd->nama;
     
        }
   
ini_set('max_execution_time', 600);
    return Excel::download(
    new Generate($ta_id, $opd_id, $gol_id, $uppd_id),
    'Generate_Tarif_'.$opd->opd.'.xlsx'
);
    }
    
    public function csv($ta_id, $opd_id, $gol_id,  $filter)
{
    ini_set('memory_limit', '3048M');
    ini_set('max_execution_time', 0);

    return Excel::download(
        new TarifCsvExport($ta_id, $opd_id, $gol_id),
        'Tarif_Keseluruhan.csv',
        ExcelFormat::CSV
    );
}
    public function usulanCsv($pengajuan_id, $id_opd, $id_golongan, $id_uppd, $filter)
{
    ini_set('memory_limit', '3048M');
    ini_set('max_execution_time', 0);

    return Excel::download(
        new UsulanTarifCsvExport($pengajuan_id, $id_opd, $id_golongan, $id_uppd, $filter),
        'Usulan_Tarif_Keseluruhan.csv',
        ExcelFormat::CSV
    );
}
        private function PDF($ta_id, $opd_id, $gol_id, $uppd_id) 
        {
            return view('generate.pdf', compact('ta_id', 'opd_id', 'gol_id', 'uppd_id', 'filter'));
        }
        private function usulanPDF($pengajuan_id, $id_opd, $id_golongan, $id_uppd) 
        {
            return view('generate.usulan_pdf', compact('pengajuan_id', 'id_opd', 'id_golongan', 'id_uppd'));
        }
        private function usulanExcel($pengajuan_id, $id_opd, $id_golongan, $id_uppd, $filter) 
        {
            $golongan=Golongan::find($id_golongan);
            $golname=$golongan->name??'-';
             $opd=Opd::find($id_opd);
                $opdname=$opd->singkatan??'-';
        if ($id_uppd == 0) {
     
            $uppd_name='Keseluruhan';
        }else{
            
            $uptd=Uppd::find($id_uppd);
            $uppd_name=$uptd->nama;
     
        }
            if ($filter == 1) {
                $nama='Usulan_Tarif_Lama';
                
            }elseif ($filter == 2) {
                $nama='Usulan_Tarif_Gabungan';
            }elseif ($filter == 3) {
                $nama='Usulan_Tarif_Baru';
            }else{
                $nama='Usulan_Tarif';
            }
            return Excel::download(new UsulanGenerate($pengajuan_id, $id_opd, $id_golongan, $id_uppd, $filter), $nama.'_'.$opdname.'_'.$golname.'_'.$uppd_name.'.xlsx');
        }
}
