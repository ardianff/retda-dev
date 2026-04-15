<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Golongan;
use App\Models\Jenis;
use App\Models\Akses;
use App\Models\Opd;
use App\Models\Uppd;
use App\Models\Satuan;
use App\Models\Rekening;
use App\Models\Pengajuan;
use App\Models\PengajuanOpd;
use App\Models\Riwayat;
use App\Models\Tarif;
use App\Models\UsulanTarif;
use App\Models\TA;
use App\Models\TahunUsulan;
use carbon\carbon;
use DB;

class UsulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     function view() 
     {
        $tu = TahunUsulan::where('status', 1)->first() ?? null;
$tahun = $tu ? $tu->tahun : date('Y');
        if (auth()->user()->level == 5) {
            $uppd=Uppd::where('id',auth()->user()->uppd_id)->where('status','Aktif')->get();
            $opd=Opd::where('id',auth()->user()->opd_id)->where('status','Aktif')->get();
    
         }
         elseif (auth()->user()->level == 4) {
             $uppd=Uppd::where('id',auth()->user()->uppd_id)->where('status','Aktif')->get();
            $opd=Opd::where('id',auth()->user()->opd_id)->where('status','Aktif')->get();
          
    
         }
         elseif (auth()->user()->level == 3) {
             $uppd=Uppd::where('opd_id',auth()->user()->opd_id)->where('status','Aktif')->get();
            $opd=Opd::where('id',auth()->user()->opd_id)->where('status','Aktif')->get();
          
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
           $opd = Opd::where('tgl_aktif', '<=', $tahun . '-12-31')
        ->where(function ($query) use ($tahun) {
            $query->whereNull('tgl_nonaktif')
            ->orWhere('tgl_nonaktif', '>=', $tahun . '-01-01');
        })
        ->get();
        $uppd=Uppd::all();
           
         }
        $golongan=Golongan::all();
    
        $tu = TahunUsulan::where('status', 1)->first() ?? null;
        $peng = $tu ? Pengajuan::where('tu_id', $tu->id)->where('status', 1)->first() : null;
        $pengOPD = $peng ? PengajuanOpd::where('pengajuan_id', $peng->id)->pluck('opd_id')->toArray() : [];
        
    //    return $pengOPD;
      $today=Carbon::now();

    return view('usulan.view',compact('opd','golongan','peng','uppd','today','tu','pengOPD')); 
    
     }

    public function index(Request $request)
    {
        $gol_id=$request->gol_id??0;
        $gol_h=Golongan::find($request->gol_id);
        $jenis_id=$request->jenis_id??0;
        $jenis_h=Jenis::find($request->jenis_id);

        $golongan=Golongan::all();
        $jenis=Jenis::all();

        $satuan=Satuan::all();
        $rekening=Rekening::all();
      
        $tu=TahunUsulan::where('status',1)->first();
        $tu_id=$tu->id;
$tahun = $tu ? $tu->tahun : date('Y');

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
            $opd = Opd::where('tgl_aktif', '<=', $tahun . '-12-31')
        ->where(function ($query) use ($tahun) {
            $query->whereNull('tgl_nonaktif')
            ->orWhere('tgl_nonaktif', '>=', $tahun . '-01-01');
        })
        ->get();
            $opd_id=$request->opd_id??auth()->user()->opd_id;
            $uppd_id=$request->uppd_id??0;
            $opd_h=Opd::find($opd_id);
            $uppd_h=Uppd::find($uppd_id);
         }

        

        return view('usulan.index',compact('golongan','gol_id','jenis','jenis_id','opd','opd_id','uppd','uppd_id','satuan','rekening','tu','gol_h','jenis_h','opd_h','uppd_h','tu_id'));
    }


    public function data(Request $request, $opd_id, $uppd_id, $gol_id, $jenis_id, $tu_id)
{
    $parentId = $request->parent_id ?? 0;
    $query =UsulanTarif::with('satuan')->where('tu_id', $tu_id);

    if ($opd_id != 0) $query->where('opd_id', $opd_id);
    if ($uppd_id != 0) $query->where('uppd_id', $uppd_id);
    if ($jenis_id != 0) $query->where('jenis_id', $jenis_id);
    if ($gol_id != 0) $query->where('golongan_id', $gol_id);

    $tarif = $query->where('parent_id',$parentId)->orderBy('number', 'ASC')->get(); // Load only parent nodes

    // return response()->json(['data' => $tarif]); 
    foreach ($tarif as $item) {
        $item->has_children =UsulanTarif::where('parent_id', $item->id)->exists();
            }
    return datatables()
        ->of($tarif)
        ->addColumn('tree', function ($tarif) {
            $hasChildren =UsulanTarif::where('parent_id', $tarif->id)->exists();
            $icon = $hasChildren 
                ? '<i class="fas fa-caret-' . ($tarif->open ? 'down' : 'right') . ' toggle-tree" data-id="' . $tarif->id . '" data-open="' . $tarif->open . '" title="List"></i>' 
                : '';
            return $icon . ' ' . $tarif->number;
        })
        ->addColumn('uraian', fn($tarif) => $tarif->uraian)
        // ->addColumn('satuan', fn($tarif) => $tarif->satuan->uraian ?? '-')
        ->addColumn('nilai', function ($tarif) {
            if ($tarif->tipe == 'body') {
                if($tarif->format_tarif == 'rupiah'){
                    $nilai=format_uang($tarif->nilai);
                }elseif($tarif->format_tarif == 'bukan_rupiah'){
                    $nilai=format_uang($tarif->nilai).$tarif->bkn_nilai;
                } elseif($tarif->format_tarif == 'up'){
                    $nilai='0';
                } else{  $nilai=$tarif->nilai;}
                return $nilai;

            }else {
                $nilai='';
            }
            return $nilai;
        })
        ->addColumn('sarana', function ($tarif) {
            if ($tarif->tipe == 'body') {
            if($tarif->format_tarif == 'rupiah'){
                $sarana=format_uang($tarif->tarif_sarana);
            }elseif($tarif->format_tarif == 'bukan_rupiah'){
                $sarana=format_uang($tarif->tarif_sarana).$tarif->bkn_nilai;
            } elseif($tarif->format_tarif == 'up'){
                $sarana='0';
            } else{$sarana=$tarif->tarif_sarana;}
            return $sarana;
        }else {
            $sarana='';
        }
        return $sarana;
        })
        ->addColumn('layanan', function ($tarif) {
            if ($tarif->tipe == 'body') {

            if($tarif->format_tarif == 'rupiah'){
                $layanan=format_uang($tarif->tarif_layanan);
            }elseif($tarif->format_tarif == 'bukan_rupiah'){
                $layanan=format_uang($tarif->tarif_layanan).$tarif->bkn_nilai;
            } elseif($tarif->format_tarif == 'up'){
                $layanan=$tarif->tarif_layanan;
            } else{$layanan=$tarif->tarif_layanan;}
            return $layanan;
        }else {
            $layanan='';
        }
        return $layanan;
        })
        ->addColumn('u_nilai', function ($tarif) {

            if ($tarif->tipe == 'body') {
                if($tarif->u_format == 'rupiah'){
                    $u_nilai=format_uang($tarif->u_nilai);
                }elseif($tarif->u_format == 'bukan_rupiah'){
                    $u_nilai=format_uang($tarif->u_nilai).$tarif->bkn_nilai;
                } elseif($tarif->u_format == 'up'){
                    $u_nilai=$tarif->u_nilai;
                } else{$u_nilai=$tarif->u_nilai;}
                return $u_nilai;

            }else {
                $u_nilai='';
            }
            return $u_nilai;
        })
        ->addColumn('u_sarana', function ($tarif) {
            if ($tarif->tipe == 'body') {

            if($tarif->u_format == 'rupiah'){
                $u_sarana=format_uang($tarif->u_sarana);
            }elseif($tarif->u_format == 'bukan_rupiah'){
                $u_sarana=format_uang($tarif->u_sarana).$tarif->bkn_nilai;
            } elseif($tarif->u_format == 'up'){
                $u_sarana='0';
            } else{$u_sarana=$tarif->u_sarana;}
            return $u_sarana;
        }else {
            $u_sarana='';
        }
        return $u_sarana;
        })
        ->addColumn('u_layanan', function ($tarif) {
            if ($tarif->tipe == 'body') {

            if($tarif->u_format == 'rupiah'){
              $u_layanan=format_uang($tarif->u_layanan);
            }elseif($tarif->u_format == 'bukan_rupiah'){
              $u_layanan=format_uang($tarif->u_layanan).$tarif->bkn_nilai;
            } elseif($tarif->u_format == 'up'){
              $u_layanan='0';
            } else{$u_layanan=$tarif->u_layanan;}
            return $u_layanan;
        }else {
            $u_layanan='';
        }
        return $u_layanan;
        })
        ->addColumn('grms_id', function ($tarif) {
            if($tarif->grms_id!=0){
                $grms_id=$tarif->grms_id;
            }  else{$grms_id='';}
            return $grms_id;
        })
        ->addColumn('satuan', function ($tarif) {
            return $tarif->satuan->uraian??'';
        })
        ->addColumn('status', function ($tarif) {
            $status = ($tarif->status == '1' ? 
            '<span class=" badge bg-success">Aktif</span>' : 
            '<span class=" badge bg-danger">Non-Aktif</span>');
            return $status;
        })
       
       
        
        ->addColumn('aksi', function ($tarif) {
            $akses = Akses::where('user_id',auth()->user()->id)->where('menu_id',17)->first();
            $user=Auth()->user();
            // Jika menu akses adalah "read only", maka tidak tampilkan kolom aksi
            // if ($akses->aksi == 0) {
            //     return '';
            // }
        
            // Button Edit & Delete
            $editBtnBody = '<button type="button" onclick="editFormbody(`'. route('usulan.edit', $tarif->id) .'`,`'. route('usulan.updateTarif', $tarif->id) .'`)" class="btn btn-xs btn-warning btn-flat" title="Ubah Tarif">
                                <i class="fas fa-pen-alt"></i>
                            </button>';
            $deleteBtn = '<button type="button" onclick="deleteForm(`'. route('usulan.destroy', $tarif->id) .'`)" class="btn btn-xs btn-danger btn-flat" title="Hapus">
                              <i class="fas fa-trash-alt"></i>
                          </button>';
            $status = ($tarif->status == '1' ? 
                '<a onclick="updateStatus(`'.$tarif->id.'`,0)" class="btn btn-success btn-xs" title="Ubah Status">
                    <i class="fas fa-check-circle"></i> 
                 </a>' : 
                '<a onclick="updateStatus(`'.$tarif->id.'`,1)" class="btn btn-danger btn-xs" title="Ubah Status">
                    <i class="far fa-times-circle"></i>
                 </a>');
        
            // Cek apakah user memiliki level 1, 2, 3, atau 6 untuk menampilkan pindah & copy
            $showPindahCopy = in_array($user->level, [1, 2, 6]);
            if ($user->akses == 'superadmin') {
                $editkode = '<button type="button" onclick="editkode(`'. route('usulan.edit', $tarif->id) .'`,`'. route('usulan.update_kode', $tarif->id) .'`)" class="btn btn-xs btn-warning btn-flat" title="Ubah Kode">
              <i class="fas fa-edit"></i>
            </button>';
            $forcedelete = '<button type="button" onclick="force_delete(`'. route('usulan.forcedelete', $tarif->id) .'`)" class="btn btn-xs btn-danger btn-flat" title="Hapus">
           Forcedelete
        </button>';
            }else{
                $editkode ='';
                $forcedelete ='';
            }
        
            $pindah = $showPindahCopy ? '<button type="button" onclick="pindahTarif(`'. route('usulan.show', $tarif->id) .'`,`'. route('usulan.pindahTarif', $tarif->id) .'`)" class="btn btn-xs bg-teal  btn-flat" title="Pindah Tarif">
                            <i class="fas fa-random"></i>
                        </button>' : '';
        
            $copy = $showPindahCopy ? '<button type="button" onclick="copyChildUsulan(`'. route('usulan.show', $tarif->id) .'`,`'. route('copytarif.childUsulan', $tarif->id) .'`)" class="btn btn-xs bg-orange  btn-flat" title="Salin Tarif">
                      <i class="far fa-copy"></i>
                    </button>' : '';
        
            if ($tarif->tipe == 'header') {
                $editBtn = '<button type="button" onclick="editForm(`'. route('usulan.edit', $tarif->id) .'`,`'. route('usulan.update', $tarif->id) .'`)" class="btn btn-xs btn-warning btn-flat" title="Ubah Header">
                                <i class="fas fa-pen-alt"></i>
                            </button>';
                $addHeaderBtn = '<button type="button" onclick="addForm(`'. route('usulan.show', $tarif->id) .'`)" class="btn btn-xs btn-primary btn-flat" title="Tambah Subheader">
                                    <i class="fas fa-plus-square"></i>
                                 </button>';
                $addBodyBtn = '<button type="button" onclick="addBody(`'. route('usulan.show', $tarif->id) .'`)" class="btn btn-xs btn-info btn-flat" title="Tambah Tarif">
                                   <i class="fas fa-plus-circle"></i>
                               </button>';
        
                $pindah = $showPindahCopy ? '<button type="button" onclick="pindahHeaderTarif(`'. route('usulan.show', $tarif->id) .'`,`'. route('usulan.pindahHeaderTarif', $tarif->id) .'`)" class="btn btn-xs bg-teal  btn-flat" title="Pindah Tarif">
                                <i class="fas fa-random"></i>
                            </button>' : '';
        
                $copy = $showPindahCopy ? '<button type="button" onclick="copyHeaderUsulan(`'. route('usulan.show', $tarif->id) .'`,`'. route('copytarif.headerUsulan', $tarif->id) .'`)" class="btn btn-xs bg-orange  btn-flat" title="Salin Tarif">
                                <i class="far fa-copy"></i>
                            </button>' : '';
        
                  return $status . ' ' . $addHeaderBtn . ' ' . $addBodyBtn . ' ' . $editBtn.''.$forcedelete;
            }
        
            return $status . ' ' . $editBtnBody.''.$forcedelete;
        })
        
        ->addColumn('row_attributes', function ($tarif) {
            return [
                'data-id' => $tarif->id,
                'data-parent-id' => $tarif->parent_id
            ];
        })
        ->rawColumns(['tree', 'aksi','nilai','u_nilai','satuan','status','grms_id','sarana','layanan','u_sarana','u_layanan'])
        ->make(true);
}

public function updateOpenStatus(Request $request)
{
    $tarif =UsulanTarif::find($request->id);
    if ($tarif) {
        $tarif->open = $request->open;
        $tarif->save();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);
    }

    return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
}


    
public function updateStatus(Request $request)
{
    $tarif = UsulanTarif::find($request->id);
    if ($tarif) {
        if ($tarif->tipe=='header'){
            $child=UsulanTarif::where('parent_id',$request->id)->get();
            foreach($child as $chil) {
                $cek=UsulanTarif::find($chil->id);
                $cek->status=$request->status;
                $cek->update();

              
            }
        }
        $tarif->status = $request->status;
        $tarif->update();

        return response()->json([
            'type' => 'success',
            'message' => 'Status berhasil diperbarui'
            ]);
    }

    return response()->json([
        'type' => 'warning',
        'message' => 'Data tidak ditemukan'
        ]);
}

public function store(Request $request)
{
    $request->validate( [
        'uraian.required' => 'Kolom uraian harus diisi.',
        'rekening.required' => 'Kolom rekening harus diisi.',
    ]);
// return $request;

// $penga=Pengajuan::with('tu')->where('id',$request->pengajuan_id)->first();
$tu=TahunUsulan::where('id',$request->tahun)->first();

if ($request->parent_id!= 0) {
    $parent=UsulanTarif::find($request->parent_id);
    $newNumber=$parent->number.'.'.$request->number;
}else{
     $newNumber=$request->number;
}

// return $newNumber;
    if ($request->retribusi == 'retribusiHeader') {

        $tarif=new UsulanTarif();
        $tarif->tarif_id=0;
        $tarif->grms_id=0;
        // $tarif->pengajuan_id=$penga->id;
        $tarif->ta_id=$tu->ta_id;
        $tarif->tu_id=$tu->id;
        $tarif->tipe=$request->tipe;
        $tarif->number=$newNumber;
        $tarif->uraian=$request->uraian;
        $tarif->satuan_id='0';
        $tarif->tarif_sarana='0';
        $tarif->tarif_layanan='0';
        $tarif->parent_id=$request->parent_id;
        $tarif->tahun=$tu->tahun;
        $tarif->opd_id=$request->opd;
        $tarif->uppd_id=$request->balai;
        $tarif->ujang_id=$request->balai;
        $tarif->golongan_id=$request->golongan;
        $tarif->jenis_id=$request->jenis;
        $tarif->rekening_id='0';
        $tarif->status=1;
        $tarif->nilai=0;
        $tarif->bkn_nilai=null;
        $tarif->format_tarif=null;
        $tarif->open=1;
        $tarif->u_format=null;
        $tarif->keterangan=$request->keterangan;
        $tarif->u_sarana=0;
        $tarif->u_layanan=0;
        $tarif->u_nilai=0;
        $tarif->save();

    } elseif ($request->retribusi == 'retribusiBody') {
        // return $request;
        // Simpan data body
        $sarana=!empty($request->sarana) ? str_replace('.', '', $request->sarana) : 0;
   $layanan=!empty($request->layanan) ? str_replace('.', '', $request->layanan) : 0;
   if ($request->jenis == 16) {

       $nilai=$sarana+$layanan;
   }else{
    $nilai=!empty($request->nilai) ? str_replace('.', '', $request->nilai) : 0;
   }
        $lastkode=UsulanTarif::max('grms_id')??0;
        $tarif=new UsulanTarif();
        $tarif->tarif_id=0;
        $tarif->grms_id=$lastkode+1;
        // $tarif->pengajuan_id=$penga->id;
        $tarif->ta_id=$tu->ta_id;
        $tarif->tu_id=$tu->id;
        $tarif->tipe=$request->tipe;
        $tarif->number=$newNumber;
        $tarif->uraian=$request->uraian;
        $tarif->satuan_id=$request->satuan;
        $tarif->tarif_sarana=0;
        $tarif->tarif_layanan=0;
        $tarif->parent_id=$request->parent_id;
        $tarif->tahun=$tu->tahun;
        $tarif->opd_id=$request->opd;
        $tarif->uppd_id=$request->balai;
        $tarif->ujang_id=$request->balai;
        $tarif->golongan_id=$request->golongan;
        $tarif->jenis_id=$request->jenis;
        $tarif->rekening_id=$request->rekening;
        $tarif->status=1;
        $tarif->nilai=0;
        $tarif->format_tarif=null;
        $tarif->bkn_nilai=$request->bkn_nilai;
        $tarif->u_format=$request->format_tarif;
        $tarif->open=1;
        $tarif->keterangan=$request->keterangan ??'';
        $tarif->penjelasan=$request->penjelasan??'';

        $tarif->u_sarana = $sarana;

        $tarif->u_layanan=$layanan;

        $tarif->u_nilai=$nilai;
        $tarif->save();

     
     
    } 
    
   return back()->with('message', [
    'type' => 'success', // success, error, warning, info
    'text' => 'Data berhasil disimpan!'
]);

}

/**
 * Display the specified resource.
 */
public function show( $id)
{
    $cek=UsulanTarif::find($id);
    if ($cek->parent_id!=0) {
        
        $tarif=UsulanTarif::with('parent')->find($id);
    }else{
       
        $tarif=UsulanTarif::find($id);
    }
    $number=UsulanTarif::where('parent_id',$id)->orderBy('number','DESC')->value('number');
    if ($number) {
        // Pisahkan string berdasarkan titik
        $parts = explode('.', $number);
    
        // Ambil angka terakhir, ubah ke integer, lalu tambahkan 1
        $lastNumber = intval(array_pop($parts)) + 1;

        $newNumber = str_pad($lastNumber, 2, '0', STR_PAD_LEFT);

    } else {
        // Jika tidak ada number sebelumnya, atur nilai default
        $newNumber ='01';
    }
    return response()->json([
        'tarif' => $tarif,
        'kode' => $cek->number,
        'number'=>$newNumber
    ]);
}

/**
 * Show the form for editing the specified resource.
 */
public function edit( $id)
{
    $cek=UsulanTarif::find($id);
    if ($cek->parent_id!=0) {
        
        $tarif=UsulanTarif::with('parent')->find($id);
        $parts = explode('.', $tarif->number);
        $number = end($parts); // Ambil bagian terakhir
    }else{
       
        $tarif=UsulanTarif::find($id);
        $number=$tarif->number;
    }
   
    return response()->json([
        'tarif' => $tarif,
        'number'=>$number
    ]);
}

/**
 * Update the specified resource in storage.
 */
public function updateTarif(Request $request, $id)
{
    
    $lama=UsulanTarif::find($id);
    // return $request;
    $sarana=!empty($request->sarana) ? str_replace('.', '', $request->sarana) : 0;
   $layanan=!empty($request->layanan) ? str_replace('.', '', $request->layanan) : 0;
   if ($lama->jenis_id == 16) {

       $nilai=$sarana+$layanan;
   }else{
    $nilai=!empty($request->nilai) ? str_replace('.', '', $request->nilai) : 0;
   }

    $parent=UsulanTarif::find($request->parent_id);
    $tarif=UsulanTarif::find($id);
        $tarif->uraian=$request->uraian;
        $tarif->satuan_id=$request->satuan;
        $tarif->u_sarana=!empty($request->sarana) ? str_replace('.', '', $request->sarana) : 0;
        $tarif->u_layanan=!empty($request->layanan) ? str_replace('.', '', $request->layanan) : 0;
   
        $tarif->rekening_id=$request->rekening;
        $tarif->number=$parent->number.'.'.$request->number;
        
        $tarif->u_nilai=$nilai;
        $tarif->bkn_nilai=$request->bkn_nilai;
        $tarif->u_format=$request->edit_format_tarif;
        $tarif->open=1;
        $tarif->keterangan=$request->keterangan;
        $tarif->penjelasan=$request->penjelasan;
        $tarif->update();

        return back()->with('message', [
            'type' => 'success', // success, error, warning, info
            'text' => 'Usulan tarif berhasil diperbarui!'
        ]);
        


}


private function updateChildrenNumber($ortu, $newParentNumber)
{
    $children = UsulanTarif::where('parent_id', $ortu->id)->get();

    foreach ($children as $child) {
        // Ambil bagian akhir dari child.number (suffix)
        $suffix = str_replace($ortu->number . '.', '', $child->number);
        $newNumber = $newParentNumber . '.' . $suffix;

        $child->number = $newNumber;
        $child->save();

        // Recursive call
        $this->updateChildrenNumber($child, $newNumber);
    }
}

public function update(Request $request,$id)
{  
    if ($request->parent_id != 0) {
        
        $parent=UsulanTarif::find($request->parent_id);
        $number=$parent->number.'.'.$request->number;
    }else{
        $number=$request->number;
    }
    $ortu=UsulanTarif::find($id);
    
    $oldNumber=$ortu->number;
    if ($oldNumber != $number) {
        // $cekortu=UsulanTarif::where('parent_id',$ortu->id)->get();
        // if ($cekortu) {

            // Update children recursively
            $this->updateChildrenNumber($ortu, $number);
        // }
    }    

        $tarif=UsulanTarif::find($id);
        $tarif->number=$number;
        $tarif->uraian=$request->uraian;
        $tarif->keterangan=$request->keterangan;
        $tarif->update();

  

        return back()->with('message', [
            'type' => 'success', // success, error, warning, info
            'text' => 'Data berhasil Diperbarui!'
        ]);
        


}


public function getHeaders(Request $request)
{
    $headers = UsulanTarif::where('tipe', 'header')
        ->where('uppd_id', $request->uppd_id)
        ->where('golongan_id', $request->gol_id)
        ->where('jenis_id', $request->jenis_id)
        ->where('status', 1)
        ->get();

    return response()->json($headers);
}

    public function pindahTarif(Request $request)
    {
        $number=UsulanTarif::where('parent_id',$request->subheader)->orderBy('number','DESC')->value('number');
       
            $parent=UsulanTarif::find($request->subheader);
             $newNumber = $parent->number.'.'.$number;

        $tarif =UsulanTarif::find($request->id);
        $tarif->uppd_id=$request->uppd_id;
        $tarif->golongan_id=$request->gol_id;
        $tarif->jenis_id=$request->jenis_id;
        $tarif->parent_id=$request->subheader;
        $tarif->number=$newNumber;

        $tarif->update();
        return response()->json([
            'type' => 'success',
            'message' => 'Data berhasil dipindah
            ']);
    
        // return $parent;
    }


  public function pindahHeaderTarif(Request $request,$id)
{
    DB::transaction(function () use ($request, $id) {

        // =========================
        // 🔹 VALIDASI
        // =========================
        $request->validate([
            'uppd_id'   => 'required',
            'gol_id'    => 'required',
            'jenis_id'  => 'required',
        ]);

        $parentId   = $id;
        $subheader  = $request->subheader ?? 0;

        // ❌ tidak boleh ke diri sendiri
        if ($subheader == $parentId) {
            throw new \Exception('Tidak boleh memindahkan ke dirinya sendiri');
        }

        // 🔹 ambil semua child (untuk validasi loop)
        $allIds = [$parentId];
        $this->getAllChildIds($parentId, $allIds);

        // ❌ tidak boleh pindah ke child sendiri
        if (in_array($subheader, $allIds)) {
            throw new \Exception('Tidak boleh memindahkan ke dalam child sendiri');
        }

        // =========================
        // 🔹 UPDATE DATA
        // =========================

        // 🔹 update child (tanpa ubah parent_id)
        DB::table('usulan_tarif')
            ->whereIn('id', $allIds)
            ->where('id', '!=', $parentId)
            ->update([
                'uppd_id'    => $request->uppd_id,
                'golongan_id'     => $request->gol_id,
                'jenis_id'   => $request->jenis_id,
                'updated_at' => now(),
            ]);

        // 🔹 tentukan parent_id baru
        $newParentId = ($subheader && $subheader != 0) ? $subheader : 0;

        // 🔹 update parent
        DB::table('usulan_tarif')
            ->where('id', $parentId)
            ->update([
                'uppd_id'    => $request->uppd_id,
                'golongan_id'     => $request->gol_id,
                'jenis_id'   => $request->jenis_id,
                'parent_id'  => $newParentId,
                'updated_at' => now(),
            ]);

        // =========================
        // 🔥 GENERATE NUMBER
        // =========================

        if ($newParentId == 0) {

            // HEADER UTAMA
            $lastNumber = DB::table('usulan_tarif')
                ->where('parent_id', 0)
                ->where('uppd_id', $request->uppd_id)
                ->where('golongan_id', $request->gol_id)
                ->where('jenis_id', $request->jenis_id)
                ->where('id', '!=', $parentId)
                ->orderByDesc('number')
                ->value('number');

           $newParentNumber = $lastNumber 
    ? str_pad(((int)$lastNumber + 1), 2, '0', STR_PAD_LEFT) 
    : '01';

        } else {

            // SUB HEADER
            $parentNumber = DB::table('usulan_tarif')
                ->where('id', $newParentId)
                ->value('number');

            $childrenNumbers = DB::table('usulan_tarif')
    ->where('parent_id', $newParentId)
    ->whereNotNull('number')
    ->pluck('number');

$parentLevel = substr_count($parentNumber, '.');

$lastIndex = 0;

foreach ($childrenNumbers as $num) {

    // hanya ambil child langsung
    if (substr_count($num, '.') == $parentLevel + 1) {

        $parts = explode('.', $num);
        $last = (int) end($parts);

        if ($last > $lastIndex) {
            $lastIndex = $last;
        }
    }
}

// generate index baru (2 digit)
$newIndex = str_pad($lastIndex + 1, 2, '0', STR_PAD_LEFT);

// hasil final
$newParentNumber = $parentNumber . '.' . $newIndex;
        }

        // 🔹 update number parent
        DB::table('usulan_tarif')
            ->where('id', $parentId)
            ->update([
                'number' => $newParentNumber
            ]);

        // 🔹 generate child
        $this->generateNumberTree($parentId, $newParentNumber);
    });

    return response()->json([
        'status'  => true,
        'message' => 'Pindah tarif berhasil + struktur aman'
    ]);
}

 private function getAllChildIds($parentId, &$ids = [])
{
    $children = DB::table('usulan_tarif')
        ->where('parent_id', $parentId)
        ->pluck('id');

    foreach ($children as $childId) {

        if (in_array($childId, $ids)) continue;

        $ids[] = $childId;

        $this->getAllChildIds($childId, $ids);
    }

    return $ids;
}
private function generateNumberTree($parentId, $parentNumber)
{
    $children = DB::table('usulan_tarif')
        ->where('parent_id', $parentId)
        ->get();

    $no = 1;

    foreach ($children as $child) {

        $newNumber = $parentNumber . '.' . str_pad($no, 2, '0', STR_PAD_LEFT);

        DB::table('usulan_tarif')
            ->where('id', $child->id)
            ->update([
                'number' => $newNumber
            ]);

        $this->generateNumberTree($child->id, $newNumber);

        $no++;
    }
}


public function update_kode(Request $request)
{
    // dd($request->all());
// return $request;
    $usulan=UsulanTarif::find($request->id);
    $usulan->number=$request->number.'.'.$request->kode;
    $usulan->update();

    return response()->json([
        'type' => 'success',
        'message' => 'kode berhasil di ubah
        ']);
}

/**
 * Remove the specified resource from storage.
 */
public function destroy( $id)
{
    $tarif=UsulanTarif::find($id);
    if ($tarif->tipe == 'header') {
        $cekanak=UsulanTarif::where('parent_id',$tarif->id)->first();
        if ($cekanak) {
            return response()->json([
                'type' => 'danger',
                'message' => 'Data header tidak dapat dihapus karena masih memiliki subtarif
                ']);
        }
    }else{

        $cek=UsulanTarif::where('id',$tarif->tarif_id)->first();
        if ($cek) {
            return response()->json([
                'type' => 'danger',
                'message' => 'Data tidak dapat dihapus karena masih terkait
                ']);
        }
    }

    // Jika tidak ada kaitan, hapus data
    $tarif->delete();

    return response()->json([
        'type' => 'success',
        'message' => 'Data berhasil dihapus
        ']);
}
public function forcedelete( $id)
{
    $tarif=UsulanTarif::find($id);
    if ($tarif->tipe == 'header') {
        $cekanak=UsulanTarif::where('parent_id',$tarif->id)->delete();
      
    }

    // Jika tidak ada kaitan, hapus data
    $tarif->delete();

    return response()->json([
        'type' => 'success',
        'message' => 'Data berhasil dihapus
        ']);
}


}

