<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Golongan;
use App\Models\Jenis;
use App\Models\Opd;
use App\Models\Uppd;
use App\Models\Satuan;
use App\Models\Rekening;
use App\Models\Pengajuan;
use App\Models\TahunUsulan;
use App\Models\Pejabat;
use App\Models\Riwayat;
use App\Models\Tarif;
use App\Models\UsulanTarif;
use App\Models\TA;
use App\Exports\UsulanExcel;
use App\Exports\UsulanExcel2;
use App\Exports\draft_excel;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PrintController extends Controller
{
       /**
     * Print Usulan
     */
    public function usulan()
    {

       if (auth()->user()->level == 5) {
           $opd=Opd::where('id',auth()->user()->opd_id)->get();
           $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
           
       }
       elseif (auth()->user()->level == 4) {
           $opd=Opd::where('id',auth()->user()->opd_id)->get();
           $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
           
           
       }
       elseif (auth()->user()->level == 3) {
           $opd=Opd::where('id',auth()->user()->opd_id)->get();
           $uppd=Uppd::where('opd_id',auth()->user()->opd_id)->get();
         
        }
        elseif (auth()->user()->level == 2) {            
           $opd=Opd::all();
           $uppd=Uppd::all();
           
       }
       elseif (auth()->user()->level == 1) {
           $opd=Opd::all();
           $uppd=Uppd::all();
           
       }
       elseif (auth()->user()->level == 6) {
           $opd=Opd::all();
           $uppd=Uppd::all();
          
        }
        $golongan=Golongan::all();
    
        $pengajuan=TahunUsulan::where('status',1)->get();
        return view('print.usulan.usulan',compact('opd','golongan','pengajuan','uppd'));
    }
   public function usulanExport(Request $request)
   {
       // return $request->uppd_id;

       $pengajuan_id = $request->pengajuan_id;
       $opd_id       = $request->opd_id;
       $uppd_id      = $request->uppd_id;
       $gol_id       = $request->gol_id;
       
       // Cari pejabat berdasarkan kondisi uppd_id
       if ($uppd_id != 0) {
           $pejabat = Pejabat::where('uppd_id', $uppd_id)->first();
       } else {
           $pejabat = Pejabat::where('opd_id', $opd_id)->first();
       }
       // return $pejabat;
       // Lanjut kalau pejabat ditemukan
       if ($pejabat) {
           if ($request->action == 'pdf') {
               return $this->usulanPDF($pengajuan_id, $opd_id, $gol_id, $uppd_id);
           } elseif ($request->action == 'excel') {
               return $this->usulanExcel($pengajuan_id, $opd_id, $gol_id, $uppd_id);
           }elseif ($request->action == 'unduhPDF') {
               return $this->unduhUsulanPDF($pengajuan_id, $opd_id, $gol_id, $uppd_id);
           }elseif ($request->action == 'rekap') {
            return $this->usulanRekap($pengajuan_id, $opd_id, $gol_id, $uppd_id);
        }else{
               return redirect()->back()->with('message', [
                   'type' => 'danger',
                   'text' => 'Aksi Tidak dikenali !!'
               ]);
           }
       }else{
           // Kalau pejabat tidak ditemukan
           return redirect()->back()->with('message', [
               'type' => 'danger',
               'text' => 'Data Pejabat Belum diisi !!'
           ]);
       }
       
   
   }
   /**
    * Store a newly created resource in storage.
    */
   private function usulanPDF($pengajuan_id, $opd_id, $gol_id, $uppd_id)
{
   ini_set('memory_limit', '512M');
   ini_set('max_execution_time', 300);

   $opd=Opd::find($opd_id);
   $golongan=Golongan::find($gol_id);
   if ($uppd_id == 0) {
       # code...
       $uppd = Uppd::where('opd_id',$opd_id)->orderBy('id_grms','ASC')->get();
   }else{
       $uppd = Uppd::where('id',$uppd_id)->orderBy('id_grms','ASC')->get();

   }
   
   $data = Jenis::where('golongan_id', $gol_id)
   ->whereHas('usulan', function ($query) use ($pengajuan_id) {
       $query->where('tu_id', $pengajuan_id)
             ->where('status', 1);
   })
   ->with(['usulan' => function ($query) use ($pengajuan_id) {
       $query->where('tu_id', $pengajuan_id)
             ->where('status', 1)
             ->where('parent_id', 0) // Hanya parent level pertama
             ->orderBy('number','ASC')
             ->with(['children' => function ($query) {
                 $query->where('status', 1)
                       ->with(['children' => function ($query) {
                           $query->where('status', 1);
                       }]);
             }]);
   }])
   ->orderBy('id','ASC')->get();

   if ($uppd_id==0) {
       $upt_id=Uppd::where('opd_id',$opd_id)->where('level',1)->first();
       $pejabat=Pejabat::where('uppd_id',$upt_id->id)->first();
   }else{

       $pejabat=Pejabat::where('uppd_id',$uppd_id)->first();
   }

   // $pdf = PDF::loadView('print.usulan.pdf', compact('data','uppd','golongan','opd','pejabat'))
   // ->setPaper([0, 0, 215.9, 330], 'landscape'); // Ukuran folio (8.5 x 13 inci) dalam mm
   // ->setOptions([
   //     'isHtml5ParserEnabled' => true,
   //     'isPhpEnabled' => true,
   // ]);
   
   // return $pdf->stream('usulan_tarif.pdf'); // Preview di browser
   // $pdf->save(storage_path('app/public/tes.pdf')); // simpan dulu

   // return response()->file(storage_path('app/public/tes.pdf')); // tampilkan
   return view('print.usulan.pdf',compact('data','uppd','golongan','opd','pejabat'));
}


   private function unduhUsulanPDF($pengajuan_id, $opd_id, $gol_id, $uppd_id)
{
   ini_set('max_execution_time', 300);
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
   $data = Jenis::where('golongan_id', $gol_id)
   ->whereHas('usulan', function ($query) use ($pengajuan_id) {
       $query->where('tu_id', $pengajuan_id)
             ->where('status', 1);
   })
   ->with(['usulan' => function ($query) use ($pengajuan_id) {
       $query->where('tu_id', $pengajuan_id)
             ->where('status', 1)
             ->where('parent_id', 0) // Hanya parent level pertama
             ->orderBy('number','ASC')
             ->with(['children' => function ($query) {
                 $query->where('status', 1)
                       ->with(['children' => function ($query) {
                           $query->where('status', 1);
                       }]);
             }]);
   }])
   ->orderBy('id','ASC')->get();


   if ($uppd_id==0) {
       $upt_id=Uppd::where('opd_id',$opd_id)->where('level',1)->first();
       $pejabat=Pejabat::where('uppd_id',$upt_id->id)->first();
   }else{

       $pejabat=Pejabat::where('uppd_id',$uppd_id)->first();
   }

   $pdf = PDF::loadView('print.usulan.pdf1', compact('data','uppd','golongan','opd','pejabat'));
   // ->setPaper([0, 0, 215.9, 330], 'landscape') // Ukuran folio (8.5 x 13 inci) dalam mm
   // ->setOptions([
   //     'isHtml5ParserEnabled' => true,
   //     'isPhpEnabled' => true,
   // ]);
   
   return $pdf->download('usulan_tarif'.$opd->opd.'-'.$uppd_name.'.pdf'); // Preview di browser
}

private function usulanExcel($pengajuan_id, $opd_id, $gol_id, $uppd_id)
{
   ini_set('max_execution_time', 300);
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
   $data = Jenis::where('golongan_id', $gol_id)
   ->whereHas('usulan', function ($query) use ($pengajuan_id) {
       $query->where('tu_id', $pengajuan_id)
             ->where('status', 1);
   })
   ->with(['usulan' => function ($query) use ($pengajuan_id) {
       $query->where('tu_id', $pengajuan_id)
             ->where('status', 1)
             ->where('parent_id', 0) // Hanya parent level pertama
             ->with(['children' => function ($query) {
                 $query->where('status', 1)
                       ->with(['children' => function ($query) {
                           $query->where('status', 1);
                       }]);
             }]);
   }])
   ->orderBy('id','ASC')->get();


   if ($uppd_id==0) {
       $upt_id=Uppd::where('opd_id',$opd_id)->where('level',1)->first();
       $pejabat=Pejabat::where('uppd_id',$upt_id->id)->first();
   }else{

       $pejabat=Pejabat::where('uppd_id',$uppd_id)->first();
   }

   return Excel::download(new UsulanExcel2( $golongan, $opd,$uppd,$data,$pejabat), 'Usulan_Tarif_OPD.xlsx');
}

private function usulanRekap($pengajuan_id, $opd_id, $gol_id, $uppd_id)
{

    $data= UsulanTarif::where('tu_id',$pengajuan_id)
    ->where('status','1')
    ->where('tipe','body')
    ->where('golongan_id',$gol_id)
    ->where('opd_id',$opd_id);
    if ($uppd_id != 0) {
       $data->where('uppd_id',$uppd_id);
    }
    $tarif=$data->select('number','status','nilai','format_tarif','bkn_nilai','u_format','tarif_layanan','tarif_sarana','u_layanan','u_sarana','u_nilai')->get();

    $jumlah_kenaikan = 0;
    $jumlah_penurunan = 0;
    $jumlah_usulan_baru = 0;
    $jumlah_perubahan_format = 0;
    $jumlah_tetap = 0;
    
    foreach ($tarif as $item) {
        if ($item->format_tarif !== $item->u_format && $item->format_tarif !== null && $item->u_format !== null) {
            $jumlah_perubahan_format++;
    
        } elseif (
            ($item->nilai == 0 && $item->u_nilai > 0) || 
            (is_null($item->format_tarif) && $item->u_format === 'rupiah' && $item->u_nilai > 0)
        ) {
            $jumlah_usulan_baru++;
    
        } elseif (
            $item->format_tarif === 'rupiah' && 
            $item->u_format === 'rupiah' && 
            $item->nilai != 0
        ) {
            if ($item->u_nilai > $item->nilai) {
                $jumlah_kenaikan++;
            } elseif ($item->u_nilai < $item->nilai) {
                $jumlah_penurunan++;
            } else {
                $jumlah_tetap++;
            }
    
        } else {
            $jumlah_tetap++;
        }
    }
    
    $data2= UsulanTarif::where('tu_id',$pengajuan_id)
    ->where('status','0')
    ->where('tipe','body')
    ->where('golongan_id',$gol_id)
    ->where('opd_id',$opd_id);
    if ($uppd_id != 0) {
       $data2->where('uppd_id',$uppd_id);
    }
    $nonAktif=$data2->count();
    // $hasil=[];
    // $hasil=[
    //     'kenaikan'=>$jumlah_kenaikan,
    //     'penurunan'=>$jumlah_penurunan,
    //     'usulan_baru'=>$jumlah_usulan_baru,
    //     'perubahan'=>$jumlah_perubahan_format,
    //     'tetap'=>$jumlah_tetap,
    //     'dihapus'=>$nonAktif,
    // ];
    
    // return $hasil;
$tu=TahunUsulan::find($pengajuan_id);
    $opd=Opd::find($opd_id);
    if ($uppd_id == 0) {
        $uppd='keseluruhan';
    }else{
        $uppd=Uppd::find($uppd_id)->value('nama');

    }

    $keseluruhan=$jumlah_kenaikan+$jumlah_penurunan+$jumlah_usulan_baru+$jumlah_perubahan_format+$jumlah_tetap;
     $pdf = PDF::loadView('print.usulan.rekap', compact('jumlah_kenaikan','jumlah_penurunan','jumlah_usulan_baru','jumlah_perubahan_format','jumlah_tetap','nonAktif','opd','uppd','tu','keseluruhan'));
 
   
   return $pdf->stream('usulan_tarif.pdf'); // Preview di browser
}

    /**
     * Print Draft Usulan
     */
    public function draft()
    {
         if (auth()->user()->level == 5) {
            $opd=Opd::where('id',auth()->user()->opd_id)->get();
            $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
            
        }
        elseif (auth()->user()->level == 4) {
            $opd=Opd::where('id',auth()->user()->opd_id)->get();
            $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
            
            
        }
        elseif (auth()->user()->level == 3) {
            $opd=Opd::where('id',auth()->user()->opd_id)->get();
            $uppd=Uppd::where('opd_id',auth()->user()->opd_id)->get();
          
         }
         elseif (auth()->user()->level == 2) {            
            $opd=Opd::all();
            $uppd=Uppd::all();
            
        }
        elseif (auth()->user()->level == 1) {
            $opd=Opd::all();
            $uppd=Uppd::all();
            
        }
        elseif (auth()->user()->level == 6) {
            $opd=Opd::all();
            $uppd=Uppd::all();
           
         }
         $golongan=Golongan::all();

         $pengajuan=TahunUsulan::where('status',1)->get();
    
        return view('print.draft.draft',compact('opd','golongan','pengajuan','uppd'));
    }

   

    public function draftexport(Request $request)
    {
        $pengajuan_id = $request->pengajuan_id;
        $opd_id = $request->opd_id;
        $uppd_id = $request->uppd_id;
        $gol_id = $request->gol_id;
    
        if ($request->action == 'pdf') {
            return $this->draftPDF($pengajuan_id, $opd_id, $gol_id, $uppd_id);
        } elseif ($request->action == 'excel') {
            return $this->draftExcel($pengajuan_id, $opd_id, $gol_id, $uppd_id);
        }elseif ($request->action == 'unduhPDF') {
            return $this->unduhDraftPDF($pengajuan_id, $opd_id, $gol_id, $uppd_id);
        }else{
            return redirect()->back()->with('message', [
                'type' => 'danger',
                'text' => 'Aksi Tidak dikenali !!'
            ]);
        }
    
        return redirect()->back()->with('message', [
            'type' => 'danger',
            'text' => 'Aksi Tidak dikenali !!'
        ]);
    }
    
    private function draftPDF($pengajuan_id, $opd_id, $gol_id, $uppd_id)
{
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 300);
    $opd=Opd::find($opd_id);
    $golongan=Golongan::find($gol_id);
    if ($uppd_id == 0) {
        $uppd = Uppd::where('opd_id',$opd_id)->where('status','Aktif')->orderBy('id_grms','ASC')->get();
        $uppd_name='Keselururhan';
    }else{
        $uppd = Uppd::where('id',$uppd_id)->where('status','Aktif')->orderBy('id_grms','ASC')->get();
        $uptd=Uppd::find($uppd_id);
        $uppd_name=$uptd->nama;
    }
    $data = Jenis::where('golongan_id', $gol_id)
    ->whereHas('usulan', function ($query) use ($pengajuan_id) {
        $query->where('tu_id', $pengajuan_id)
              ->where('status', 1);
    })
    ->with(['usulan' => function ($query) use ($pengajuan_id) {
        $query->where('tu_id', $pengajuan_id)
              ->where('status', 1)
              ->where('parent_id', 0) // Hanya parent level pertama
              ->with(['children' => function ($query) {
                  $query->where('status', 1)
                        ->with(['children' => function ($query) {
                            $query->where('status', 1);
                        }]);
              }]);
    }])
    ->orderBy('id','ASC')->get();


//    dd($data->toArray());
    // $pdf = PDF::loadView('print.draft.draft_pdf', compact('data','uppd','golongan','opd'));
    // return $pdf->stream('usulan_tarif.pdf'); // Preview di browser

    return view('print.draft.draft_pdf',compact('data','uppd','golongan','opd'));
}

    private function unduhDraftPDF($pengajuan_id, $opd_id, $gol_id, $uppd_id)
{
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 300);
    $opd=Opd::find($opd_id);
    $golongan=Golongan::find($gol_id);
    if ($uppd_id == 0) {
        # code...
        $uppd = Uppd::where('opd_id',$opd_id)->where('status','Aktif')->orderBy('id_grms','ASC')->get();
    }else{
        $uppd = Uppd::where('id',$uppd_id)->where('status','Aktif')->orderBy('id_grms','ASC')->get();

    }
    $data = Jenis::where('golongan_id', $gol_id)
    ->whereHas('usulan', function ($query) use ($pengajuan_id) {
        $query->where('tu_id', $pengajuan_id)
              ->where('status', 1);
    })
    ->with(['usulan' => function ($query) use ($pengajuan_id) {
        $query->where('tu_id', $pengajuan_id)
              ->where('status', 1)
              ->where('parent_id', 0) // Hanya parent level pertama
              ->orderBy('number','ASC')
              ->with(['children' => function ($query) {
                  $query->where('status', 1)
                        ->with(['children' => function ($query) {
                            $query->where('status', 1);
                        }]);
              }]);
    }])
    ->orderBy('id','ASC')->get();


//    dd($data->toArray());
    $pdf = PDF::loadView('print.draft.draft_pdf', compact('data','uppd','golongan','opd'));
    // return $pdf->stream('usulan_tarif.pdf'); // Preview di browser
    return $pdf->download('Draft_tarif'.$opd->opd.'-'.$uppd_name.'.pdf'); // Preview di browser
    // return view('print.draft.draft_pdf',compact('data','uppd','golongan','opd'));
}

private function draftExcel($pengajuan_id, $opd_id, $gol_id,$uppd_id)
{

    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 300);
    $opd=Opd::find($opd_id);
    $golongan=Golongan::find($gol_id);
    if ($uppd_id == 0) {
        # code...
        $uppd = Uppd::where('opd_id',$opd_id)->where('status','Aktif')->orderBy('id_grms','ASC')->get();
    }else{
        $uppd = Uppd::where('id',$uppd_id)->where('status','Aktif')->orderBy('id_grms','ASC')->get();

    }
    $data = Jenis::where('golongan_id', $gol_id)
    ->whereHas('usulan', function ($query) use ($pengajuan_id) {
        $query->where('tu_id', $pengajuan_id)
              ->where('status', 1);
    })
    ->with(['usulan' => function ($query) use ($pengajuan_id) {
        $query->where('tu_id', $pengajuan_id)
              ->where('status', 1)
              ->where('parent_id', 0) // Hanya parent level pertama
              ->orderBy('number','ASC')
              ->with(['children' => function ($query) {
                  $query->where('status', 1)
                        ->with(['children' => function ($query) {
                            $query->where('status', 1);
                        }]);
              }]);
    }])
    ->orderBy('id','ASC')->get();

    return Excel::download(new draft_excel( $golongan, $opd,$uppd,$data), 'Draft_Tarif_'.$opd->opd.'.xlsx');
}

    /**
     * Print Lampiran
     */
    public function Lampiran()
    {

        if (auth()->user()->level == 5) {
            $opd=Opd::where('id',auth()->user()->opd_id)->get();
            $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
            
        }
        elseif (auth()->user()->level == 4) {
            $opd=Opd::where('id',auth()->user()->opd_id)->get();
            $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
            
            
        }
        elseif (auth()->user()->level == 3) {
            $opd=Opd::where('id',auth()->user()->opd_id)->get();
            $uppd=Uppd::where('opd_id',auth()->user()->opd_id)->get();
          
         }
         elseif (auth()->user()->level == 2) {            
            $opd=Opd::all();
            $uppd=Uppd::all();
            
        }
        elseif (auth()->user()->level == 1) {
            $opd=Opd::all();
            $uppd=Uppd::all();
            
        }
        elseif (auth()->user()->level == 6) {
            $opd=Opd::all();
            $uppd=Uppd::all();
           
         }
         $golongan=Golongan::all();
    
        $ta=TA::all();
        return view('print.lampiran.lampiran',compact('opd','golongan','ta','uppd'));
    }

 
    public function LampiranExport(Request $request)
    {
        $ta_id = $request->ta_id;
        $opd_id = $request->opd_id;
        $gol_id = $request->gol_id;
        $uppd_id = $request->uppd_id;
    
        if ($request->action == 'pdf') {
            return $this->lampiranPDF($ta_id, $opd_id, $gol_id, $uppd_id);
        } elseif ($request->action == 'excel') {
            return $this->lampiranExcel($ta_id, $opd_id, $gol_id, $uppd_id);
        }
    
        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }

   
    private function lampiranPDF($ta_id, $opd_id, $gol_id,$uppd_id)
    {
        $ta=TA::find($ta_id);
        $opd=Opd::find($opd_id);
        $golongan=Golongan::find($gol_id);
        if ($uppd_id == 0) {
            # code...
            $uppd = Uppd::where('opd_id',$opd_id)->orderBy('id_grms','ASC')->get();
        }else{
            $uppd = Uppd::where('id',$uppd_id)->orderBy('id_grms','ASC')->get();

        }
        $data = Jenis::where('golongan_id', $gol_id)
    ->whereHas('tarif', function ($query) use ($ta_id) {
        $query->where('ta_id', $ta_id)
              ->where('status', 1);
    })
    ->with(['tarif' => function ($query) use ($ta_id) {
        $query->where('ta_id', $ta_id)
              ->where('status', 1);
    }, 'tarif.children' => function ($query) { // Filter hanya children yang aktif
        $query->where('status', 1);
    }])
    ->get();
    if ($uppd_id==0) {
        
        $pejabat=Pejabat::where('opd_id',$opd_id)->first();
    }else{

        $pejabat=Pejabat::where('uppd_id',$uppd_id)->first();
    }

        $pdf = PDF::loadView('print.lampiran.pdf', compact('data','uppd','golongan','opd','ta','pejabat','uppd'))
        ->setPaper([0, 0, 215.9, 330], 'Portrait') // Ukuran folio (8.5 x 13 inci) dalam mm
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
        ]);
        return $pdf->stream('lampiranTarif.pdf'); // Preview di browser
    }


 
}
