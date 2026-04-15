<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Excel;

use App\Models\Golongan;
use App\Models\Jenis;
use App\Models\Opd;
use App\Models\Uppd;
use App\Models\Satuan;
use App\Models\Rekening;
use App\Models\Tarif;
use App\Models\Importtarif;
use App\Models\TA;

class InfoController extends Controller
{
    function view()
{
    if (auth()->user()->level == 5) {
        $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
        $opd=Opd::where('id',auth()->user()->opd_id)->get();
     }
     elseif (auth()->user()->level == 4) {
         $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
        $opd=Opd::where('id',auth()->user()->opd_id)->get();
     }
     elseif (auth()->user()->level == 3) {
         $uppd=Uppd::where('opd_id',auth()->user()->opd_id)->get();
        $opd=Opd::where('id',auth()->user()->opd_id)->get(); 
     }
     elseif (auth()->user()->level == 2) {
        $uppd=Uppd::all(); 
        $opd=Opd::all();
     }
     elseif (auth()->user()->level == 1) {
        $uppd=Uppd::all();
        $opd=Opd::all();
     }
     elseif (auth()->user()->level == 6) {
        $uppd=Uppd::all();
        $opd=Opd::all();
     }
    $golongan=Golongan::all();

    $TA=TA::all();
    $tahun=TA::where('status','Aktif')->first();
    $thn_id=$tahun->id;

return view('info.view',compact('opd','golongan','TA','thn_id','uppd'));
}


    public function index(Request $request)
    {
        if (auth()->user()->level == 5) {
            $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
            $opd=Opd::where('id',auth()->user()->opd_id)->get();
            $opd_id=auth()->user()->opd_id;
            $uppd_id=auth()->user()->uppd_id;
            $opd_h=Opd::find($opd_id);
            $uppd_h=Uppd::find($uppd_id);
    
         }
         elseif (auth()->user()->level == 4) {
             $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
            $opd=Opd::where('id',auth()->user()->opd_id)->get();
            $opd_id=auth()->user()->opd_id;
            $uppd_id=auth()->user()->uppd_id;
            $opd_h=Opd::find($opd_id);
            $uppd_h=Uppd::find($uppd_id);
         }
         elseif (auth()->user()->level == 3) {
             $uppd=Uppd::where('opd_id',auth()->user()->opd_id)->get();
            $opd=Opd::where('id',auth()->user()->opd_id)->get();
            $opd_id=auth()->user()->opd_id;
            $uppd_id=$request->uppd_id??0;
            $opd_h=Opd::find($opd_id);
            $uppd_h=Uppd::find($uppd_id);
         }
         elseif (auth()->user()->level == 2) {
            if ($request->opd_id) {
                $uppd=Uppd::where('opd_id',$request->opd_id)->get();
            }else{
    
                $uppd=Uppd::all();
            }
            $opd=Opd::all();
            $opd_id=$request->opd_id??auth()->user()->opd_id;
            $uppd_id=$request->uppd_id??0;
            $opd_h=Opd::find($opd_id);
            $uppd_h=Uppd::find($uppd_id);
         }
         elseif (auth()->user()->level == 1) {
            if ($request->opd_id) {
                $uppd=Uppd::where('opd_id',$request->opd_id)->get();
            }else{
    
                $uppd=Uppd::all();
            }
            $opd=Opd::all();
            $opd_id=$request->opd_id??0;
            $uppd_id=$request->uppd_id??0;
            $opd_h=Opd::find($opd_id);
            $uppd_h=Uppd::find($uppd_id);
         }
         elseif (auth()->user()->level == 6) {
            if ($request->opd_id) {
                $uppd=Uppd::where('opd_id',$request->opd_id)->get();
            }else{
    
                $uppd=Uppd::all();
            }
            $opd=Opd::all();
            $opd_id=$request->opd_id??auth()->user()->opd_id;
            $uppd_id=$request->uppd_id??0;
            $opd_h=Opd::find($opd_id);
            $uppd_h=Uppd::find($uppd_id);
         }

        $gol_id=$request->gol_id??0;
        $gol_h=Golongan::find($request->gol_id);
        $jenis_id=$request->jenis_id??0;
        $jenis_h=Jenis::find($request->jenis_id);

        $golongan=Golongan::all();
        $jenis=Jenis::where('golongan_id',$request->gol_id)->get();

        $satuan=Satuan::all();
        $rekening=Rekening::all();
      
        $TA=TA::all();
        $thn_id=$request->thn_id;


        return view('info.index',compact('golongan','gol_id','jenis','jenis_id','opd','opd_id','uppd','uppd_id','satuan','rekening','TA','thn_id','gol_h','jenis_h','opd_h','uppd_h'));
    }

    /**
     * Show the form for creating a new resource.
     */
   
    
    public function data(Request $request, $opd_id, $uppd_id, $gol_id, $jenis_id, $thn_id)
{
    $parentId = $request->parent_id ?? 0;
    $query = Importtarif::with('satuan')->where('ta_id', $thn_id);

    if ($opd_id != 0) $query->where('opd_id', $opd_id);
    if ($uppd_id != 0) $query->where('uppd_id', $uppd_id);
    if ($jenis_id != 0) $query->where('jenis_id', $jenis_id);
    if ($gol_id != 0) $query->where('golongan_id', $gol_id);

    $tarif = $query->where('parent_id',$parentId)->orderBy("number","ASC")->get(); // Load only parent nodes

    // return response()->json(['data' => $tarif]); 
    foreach ($tarif as $item) {
        $item->has_children = Importtarif::where('parent_id', $item->id)->exists();
            }
    return datatables()
        ->of($tarif)
        ->addColumn('tree', function ($tarif) {
            $hasChildren = Importtarif::where('parent_id', $tarif->id)->exists();
            $icon = $hasChildren 
                ? '<i class="fas fa-chevron-circle-' . ($tarif->open ? 'down' : 'right') . ' toggle-tree" data-id="' . $tarif->id . '" data-open="' . $tarif->open . '"></i>' 
                : '';
            return $icon . ' ' . $tarif->number;
        })
        ->addColumn('uraian', fn($tarif) => $tarif->uraian)
        // ->addColumn('satuan', fn($tarif) => $tarif->satuan->uraian ?? '-')
        ->addColumn('nilai', function ($tarif) {
            if($tarif->bukan_nilai==1){
                $nilai=$tarif->nilai;
            } elseif ($tarif->up!=0){
                $nilai=$tarif->nilai;
            }elseif ($tarif->nilai!=0){
                $nilai=format_uang($tarif->nilai);
            } else{$nilai='';}
            return $nilai;
        })
        ->addColumn('sarana', function ($tarif) {
            if($tarif->bukan_nilai==1){
                $sarana='';
            }elseif($tarif->tarif_sarana!=0){
                $sarana=format_uang($tarif->tarif_sarana);
            }  else{$sarana='';}
            return $sarana;
        })
        ->addColumn('layanan', function ($tarif) {
            if($tarif->bukan_nilai==1){
                $layanan='';
            }elseif($tarif->tarif_layanan!=0){
                $layanan=format_uang($tarif->tarif_layanan);
            }  else{$layanan='';}
            return $layanan;
        })
        ->addColumn('satuan', function ($tarif) {
            return $tarif->satuan->uraian??'';
        })
        ->addColumn('status', function ($tarif) {
            return ($tarif->status==1?'Aktif':'Non Aktif');
        })
        ->addColumn('grms_id', function ($tarif) {
            if($tarif->grms_id!=0){
                $grms=$tarif->grms_id;
            }  else{$grms='';}
            return $grms;

        })
       
       
        
        ->addColumn('row_attributes', function ($tarif) {
            return [
                'data-id' => $tarif->id,
                'data-parent-id' => $tarif->parent_id
            ];
        })
        ->rawColumns(['tree','nilai','satuan','grms_id','sarana','layanan','status'])
        ->make(true);
}
public function updateOpenStatus(Request $request)
{
    $tarif = Importtarif::find($request->id);
    if ($tarif) {
        $tarif->open = $request->open;
        $tarif->save();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);
    }

    return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
}

function importUsulan(Request $request) 
{
    // return $request->file('usulan');
    Excel::Import(new \App\Imports\UsulanImport,$request->file('usulan'));

    return back()->with('message', [
        'type' => 'success', // success, error, warning, info
        'text' => 'Data berhasil disimpan!'
    ]);
    
}
}
