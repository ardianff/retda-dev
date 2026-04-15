<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Golongan;
use App\Models\Jenis;
use App\Models\Opd;
use App\Models\Uppd;
use App\Models\Satuan;
use App\Models\Rekening;
use App\Models\Tarif;
use App\Models\TA;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
function view()
{
    $TA=TA::all();
    $thn_id=TA::where('status','Aktif')->first();
    $tahun=$thn_id->tahun;
    
    if (auth()->user()->level == 5) {
        // $opd=Opd::where('id',auth()->user()->opd_id)->get();
        
        $opd = Opd::where('id',auth()->user()->opd_id)
        ->where('tgl_aktif', '<=', $tahun . '-12-31')
        ->where(function ($query) use ($tahun) {
            $query->whereNull('tgl_nonaktif')
            ->orWhere('tgl_nonaktif', '>=', $tahun . '-01-01');
        })
        ->get();
        if ($opd) {
           
            $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
        }else{
            $uppd='';

        }

     }
     elseif (auth()->user()->level == 4) {
        //  $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
        $opd = Opd::where('id',auth()->user()->opd_id)
        ->where('tgl_aktif', '<=', $tahun . '-12-31')
        ->where(function ($query) use ($tahun) {
            $query->whereNull('tgl_nonaktif')
            ->orWhere('tgl_nonaktif', '>=', $tahun . '-01-01');
        })
        ->get();
      
        if ($opd) {
           
            $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
        }else{
            $uppd='';

        }
     }
     elseif (auth()->user()->level == 3) {
        // $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
        $opd = Opd::where('id',auth()->user()->opd_id)
        ->where('tgl_aktif', '<=', $tahun . '-12-31')
        ->where(function ($query) use ($tahun) {
            $query->whereNull('tgl_nonaktif')
            ->orWhere('tgl_nonaktif', '>=', $tahun . '-01-01');
        })
        ->get();
      
        if ($opd) {
           
            $uppd=Uppd::where('opd_id',auth()->user()->opd_id)->get();
        }else{
            $uppd='';

        }
      
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
     $opd = Opd::where('tgl_aktif', '<=', $tahun . '-12-31')
        ->where(function ($query) use ($tahun) {
            $query->whereNull('tgl_nonaktif')
            ->orWhere('tgl_nonaktif', '>=', $tahun . '-01-01');
        })
        ->get();
        $uppd=Uppd::all();
        // $opd=Opd::all();
       
     }
    $golongan=Golongan::all();

   

return view('tarif.view',compact('opd','golongan','TA','thn_id','uppd'));
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


        return view('tarif.index',compact('golongan','gol_id','jenis','jenis_id','opd','opd_id','uppd','uppd_id','satuan','rekening','TA','thn_id','gol_h','jenis_h','opd_h','uppd_h'));
    }

    /**
     * Show the form for creating a new resource.
     */
   
    
    public function data(Request $request, $opd_id, $uppd_id, $gol_id, $jenis_id, $thn_id)
{
    $parentId = $request->parent_id ?? 0;
    $query = Tarif::with('satuan')->where('ta_id', $thn_id);

    if ($opd_id != 0) $query->where('opd_id', $opd_id);
    if ($uppd_id != 0) $query->where('uppd_id', $uppd_id);
    if ($jenis_id != 0) $query->where('jenis_id', $jenis_id);
    if ($gol_id != 0) $query->where('golongan_id', $gol_id);

    $tarif = $query->where('parent_id',$parentId)->orderBy("number","ASC")->get(); // Load only parent nodes

    // return response()->json(['data' => $tarif]); 
    foreach ($tarif as $item) {
        $item->has_children = Tarif::where('parent_id', $item->id)->exists();
            }
    return datatables()
        ->of($tarif)
        ->addColumn('tree', function ($tarif) {
            $hasChildren = Tarif::where('parent_id', $tarif->id)->exists();
            $icon = $hasChildren 
                ? '<i class="fas fa-chevron-circle-' . ($tarif->open ? 'down' : 'right') . ' toggle-tree" data-id="' . $tarif->id . '" data-open="' . $tarif->open . '"></i>' 
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
                    $nilai=format_uang($tarif->nilai).$tarif->bukan_nilai;
                } elseif($tarif->format_tarif == 'up'){
                    $nilai=$tarif->nilai;
                } else{$nilai=$tarif->nilai;}
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
                    $sarana=format_uang($tarif->tarif_sarana).$tarif->bukan_nilai;
                } elseif($tarif->format_tarif == 'up'){
                    $sarana=$tarif->tarif_sarana;
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
                    $layanan=format_uang($tarif->tarif_layanan).$tarif->bukan_nilai;
                } elseif($tarif->format_tarif == 'up'){
                    $layanan=$tarif->tarif_layanan;
                } else{$layanan=$tarif->tarif_layanan;}
                return $layanan;

            }else {
                $layanan='';
            }
            return $layanan;
        })
        ->addColumn('satuan', function ($tarif) {
            return $tarif->satuan->uraian??'';
        })
        ->addColumn('grms_id', function ($tarif) {
            if($tarif->grms_id!=0){
                $grms=$tarif->grms_id;
            }  else{$grms='';}
            return $grms;

        })
       
        ->addColumn('aksi', function ($tarif) {
            $editBtnBody = '<button type="button" onclick="editFormbody(`'. route('tarif.show', $tarif->id) .'`,`'. route('tarif.updateTarif', $tarif->id) .'`)" class="btn btn-xs btn-warning btn-flat" title="Ubah Tarif">
                                <i class="fas fa-pen-alt"></i>
                            </button>';
            $deleteBtn = '<button type="button" onclick="deleteForm(`'. route('tarif.destroy', $tarif->id) .'`)" class="btn btn-xs btn-danger btn-flat" title="Hapus">
                              <i class="fas fa-trash-alt"></i>
                          </button>';
            $status = ($tarif->status == '1' ? 
                '<a onclick="updateStatus(`'.$tarif->id.'`,0)" class="btn btn-success btn-xs" title="Ubah Status">
                    <i class="fas fa-check-circle"></i> 
                 </a>' : 
                '<a onclick="updateStatus(`'.$tarif->id.'`,1)" class="btn btn-danger btn-xs" title="Ubah Status">
                    <i class="far fa-times-circle"></i>
                 </a>');

            $pindah = '<button type="button" onclick="pindahTarif(`'. route('tarif.show', $tarif->id) .'`,`'. route('tarif.pindahTarif', $tarif->id) .'`)" class="btn btn-xs bg-teal  btn-flat" title="Pindah Tarif">
                <i class="fas fa-random"></i>
            </button>';

            if (auth()->user()->level == 1) {
                $generate= '<a href="'.route('generate.tarif',$tarif->id).'" class="btn btn-info btn-xs" title="Ubah Status">
                    <i class="far fa-file-excel"></i>
                 </a>';
            }else {
                $generate = '';
            }

            if ($tarif->tipe == 'header') {
                $editBtn = '<button type="button" onclick="editForm(`'. route('tarif.update', $tarif->id) .'`)" class="btn btn-xs btn-warning btn-flat" title="Ubah Header">
                                <i class="fas fa-pen-alt"></i>
                            </button>';
                $addHeaderBtn = '<button type="button" onclick="addForm(`'. route('tarif.show', $tarif->id) .'`)" class="btn btn-xs btn-primary btn-flat" title="Tambah Subheader">
                                    <i class="fas fa-plus-square"></i>
                                 </button>';
                $addBodyBtn = '<button type="button" onclick="addBody(`'. route('tarif.show', $tarif->id) .'`)" class="btn btn-xs btn-info btn-flat" title="Tambah Tarif">
                                   <i class="fas fa-plus-circle"></i>
                               </button>';
                $pindah = '<button type="button" onclick="pindahHeaderTarif(`'. route('tarif.show', $tarif->id) .'`,`'. route('tarif.pindahHeaderTarif', $tarif->id) .'`)" class="btn btn-xs bg-teal  btn-flat" title="Pindah Tarif">
                <i class="fas fa-random"></i>
            </button>';
        
                return $status . ' ' . $addHeaderBtn . ' ' . $addBodyBtn . ' ' . $editBtn.' '.$pindah;
            }
        
            return $status . ' ' . $editBtnBody.' '.$pindah.' '.$generate;
        })
        
        ->addColumn('row_attributes', function ($tarif) {
            return [
                'data-id' => $tarif->id,
                'data-parent-id' => $tarif->parent_id
            ];
        })
        ->rawColumns(['tree', 'aksi','nilai','satuan','grms_id','sarana','layanan'])
        ->make(true);
}

public function updateOpenStatus(Request $request)
{
    $tarif = Tarif::find($request->id);
    if ($tarif) {
        $tarif->open = $request->open;
        $tarif->save();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);
    }

    return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
}


public function updateStatus(Request $request)
{
    $tarif = Tarif::find($request->id);
    if ($tarif) {
        if ($tarif->tipe=='header'){
            $child=Tarif::where('parent_id',$request->id)->get();
            foreach($child as $chil) {
                $cek=Tarif::find($chil->id);
                $cek->status=$request->status;
                $cek->update();
            }
        }
        $tarif->status = $request->status;
        $tarif->update();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);
    }

    return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'uraian.required' => 'Kolom uraian harus diisi.',
            'rekening.required' => 'Kolom uraian harus diisi.',
        ]);
// return $request;
$tahun=TA::find($request->tahun);
// return $request->tahun;
if ($request->parent_id !=0) {

    $number=Tarif::where('parent_id',$request->parent_id)->orderBy('number','DESC')->value('number');
    if ($number) {
        // Pisahkan string berdasarkan titik
        $parts = explode('.', $number);
    
        // Ambil angka terakhir, ubah ke integer, lalu tambahkan 1
        $lastNumber = intval(array_pop($parts)) + 1;
    
        $lastNumber = str_pad($lastNumber, 2, '0', STR_PAD_LEFT);
        // Gabungkan kembali dengan titik
        $newNumber = implode('.', $parts) . '.' . $lastNumber;
    } else {
        // Jika tidak ada number sebelumnya, atur nilai default
        $parent=Tarif::find($request->subheader);
        $newNumber = $parent.'01';
    }
    
    }else{
    $number=Tarif::where('ta_id',$tahun->id)
    ->where('opd_id',$request->opd)
    ->where('uppd_id',$request->balai)
    ->where('golongan_id',$request->golongan)
    ->where('jenis_id',$request->jenis)
    ->orderBy('number','DESC')->value('number');
    
        if ($number) {
            // Pisahkan string berdasarkan titik
            $parts = explode('.', $number);
        
            // Ambil angka terakhir, ubah ke integer, lalu tambahkan 1
            $lastNumber = intval(array_pop($parts)) + 1;
        
            $lastNumber = str_pad($lastNumber, 2, '0', STR_PAD_LEFT);
            // Gabungkan kembali dengan titik
            $newNumber = implode('.', $parts) . '.' . $lastNumber;
        } else {
            // Jika tidak ada number sebelumnya, atur nilai default
            $parent=Tarif::find($request->subheader);
            $newNumber = $parent.'01';
        }
    }
    
        if ($request->retribusi == 'retribusiHeader') {
    
            $tarif=new Tarif();
            $tarif->number=$newNumber;
            $tarif->grms_id=0;
            $tarif->uraian=$request->uraian;
            $tarif->satuan_id='0';
            $tarif->tarif_sarana='0';
            $tarif->tarif_layanan='0';
            $tarif->parent_id=$request->parent_id;
            $tarif->tahun=$tahun->tahun;
            $tarif->ta_id=$request->tahun;
            $tarif->opd_id=$request->opd;
            $tarif->uppd_id=$request->balai;
            $tarif->ujang_id=$request->balai;
            $tarif->golongan_id=$request->golongan;
            $tarif->jenis_id=$request->jenis;
            $tarif->rekening_id='0';
            $tarif->status=1;
            $tarif->nilai=0;
            $tarif->bukan_nilai=null;
            $tarif->tipe=$request->tipe;
            $tarif->open=1;
            $tarif->format_tarif=null;
            $tarif->keterangan=$request->keterangan;
            $tarif->save();
    
        } elseif ($request->retribusi == 'retribusiBody') {
            // Simpan data header
            $sarana=!empty($request->sarana) ? str_replace('.', '', $request->sarana) : 0;
   $layanan=!empty($request->layanan) ? str_replace('.', '', $request->layanan) : 0;
   if ($request->jenis == 16) {

       $nilai=$sarana+$layanan;
   }else{
    $nilai=!empty($request->nilai) ? str_replace('.', '', $request->nilai) : 0;
   }
            $lastkode=Tarif::max('grms_id')??0;
            $tarif=new Tarif();
            $tarif->grms_id=$lastkode+1;
            $tarif->number=$newNumber;
            $tarif->uraian=$request->uraian;
            $tarif->satuan_id=$request->satuan;
            $tarif->tarif_sarana=!empty($request->sarana) ? str_replace('.', '', $request->sarana) : 0;
            $tarif->tarif_layanan=!empty($request->layanan) ? str_replace('.', '', $request->layanan) : 0;
            $tarif->parent_id=$request->parent_id;
            $tarif->tahun=$tahun->tahun;
            $tarif->ta_id=$request->tahun;
            $tarif->opd_id=$request->opd;
            $tarif->uppd_id=$request->balai;
            $tarif->ujang_id=$request->balai;
            $tarif->golongan_id=$request->golongan;
            $tarif->jenis_id=$request->jenis;
            $tarif->rekening_id=$request->rekening;
            $tarif->status=1;
            $tarif->nilai=$nilai;
            $tarif->bukan_nilai=$request->bkn_nilai;
            $tarif->tipe=$request->tipe;
            $tarif->format_tarif=$request->format_tarif;;
            $tarif->keterangan=$request->keterangan;
            $tarif->open=1;
            $tarif->save();
        } 
       
     
       return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {

        $cek=Tarif::find($id);
        if ($cek->parent_id!=0) {
            
            $tarif=Tarif::with('parent')->find($id);
        }else{
            $tarif=Tarif::find($id);
        }
    
        // $tarif=Tarif::find($id);

        return response()->json($tarif);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTarif(Request $request)
    { 
        $id=$request->id;

    $lama=Tarif::find($id);

        $sarana=!empty($request->sarana) ? str_replace('.', '', $request->sarana) : 0;
   $layanan=!empty($request->layanan) ? str_replace('.', '', $request->layanan) : 0;
   if ($lama->jenis_id == 16) {

       $nilai=$sarana+$layanan;
   }else{
    $nilai=!empty($request->nilai) ? str_replace('.', '', $request->nilai) : 0;
   }
        $tarif=Tarif::find($id);
            $tarif->uraian=$request->uraian;
            $tarif->satuan_id=$request->satuan;
            $tarif->tarif_sarana=!empty($request->sarana) ? str_replace('.', '', $request->sarana) : 0;

            $tarif->tarif_layanan=!empty($request->layanan) ? str_replace('.', '', $request->layanan) : 0;

        
            $tarif->rekening_id=$request->rekening;
            $tarif->keterangan=$request->keterangan;

            
            $tarif->nilai=$nilai;
            $tarif->bukan_nilai=$request->bkn_nilai;
            $tarif->format_tarif=$request->edit_format_tarif;
            $tarif->open=1;
            $tarif->update();

            return back()->with(['status' => 'success', 'message' => 'Operation successful']);



    }

    public function getHeaders(Request $request)
{
    $headers = Tarif::where('tipe', 'header')
        ->where('uppd_id', $request->uppd_id)
        ->where('golongan_id', $request->gol_id)
        ->where('jenis_id', $request->jenis_id)
        ->get();

    return response()->json($headers);
}

    public function pindahTarif(Request $request)
    {
        $number=Tarif::where('parent_id',$request->subheader)->orderBy('number','DESC')->value('number');
        if ($number) {
            // Pisahkan string berdasarkan titik
            $parts = explode('.', $number);
        
            // Ambil angka terakhir, ubah ke integer, lalu tambahkan 1
            $lastNumber = intval(array_pop($parts)) + 1;

            $lastNumber = str_pad($lastNumber, 2, '0', STR_PAD_LEFT);
            // Gabungkan kembali dengan titik
            $newNumber = implode('.', $parts) . '.' . $lastNumber;
        } else {
            // Jika tidak ada number sebelumnya, atur nilai default
            $parent=Tarif::find($request->subheader);
            $newNumber = $parent.'01';
        }
        
        
        $tarif =Tarif::find($request->id);
        $tarif->opd_id=$request->opd_id;
        $tarif->uppd_id=$request->uppd_id;
        $tarif->golongan_id=$request->gol_id;
        $tarif->jenis_id=$request->jenis_id;
        $tarif->parent_id=$request->subheader;
        $tarif->number=$newNumber;

        $tarif->update();
        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);



        // return $parent;
    }


    public function pindahHeaderTarif(Request $request,$id)
    {
        if ($request->subheader == '0' ) {
        $number=Tarif::where('uppd_id',$request->uppd_id)
        ->where('golongan_id',$request->gol_id)
        ->where('jenis_id',$request->jenis_id)
        ->where('parent_id',0)
        ->orderBy('number','DESC')->value('number');
        $newNumber=$number+1;
        $newNumber = str_pad($newNumber, 2, '0', STR_PAD_LEFT);
        }else{

            $number=Tarif::where('parent_id',$request->subheader)->orderBy('number','DESC')->value('number');
            if ($number) {
                // Pisahkan string berdasarkan titik
                $parts = explode('.', $number);
                
                // Ambil angka terakhir, ubah ke integer, lalu tambahkan 1
                $lastNumber = intval(array_pop($parts)) + 1;
                
                $lastNumber = str_pad($lastNumber, 2, '0', STR_PAD_LEFT);
                // Gabungkan kembali dengan titik
                $newNumber = implode('.', $parts) . '.' . $lastNumber;
            } else {
                // Jika tidak ada number sebelumnya, atur nilai default
                $parent=Tarif::find($request->subheader);
                $newNumber = $parent.'01';
            }
        }
        
        $tarif = Tarif::find($id);
        $tarif->opd_id = $request->opd_id;
        $tarif->uppd_id = $request->uppd_id;
        $tarif->golongan_id = $request->gol_id;
        $tarif->jenis_id = $request->jenis_id;
        $tarif->parent_id = $request->subheader;
        $tarif->number = $newNumber;
        $tarif->keterangan = $request->keterangan;
        $tarif->update();
        
        // Perbarui semua anak secara rekursif
        $this->updateChildNumber($tarif->id, $newNumber,$tarif->opd_id, $tarif->uppd_id, $tarif->golongan_id, $tarif->jenis_id);
        
        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);



        // return $parent;
    }

   

/**
 * Fungsi rekursif untuk memperbarui nomor child dan semua turunannya
 */
function updateChildNumber($parentId, $parentNumber,$opdId, $uppdId, $golonganId, $jenisId)
{
    $anak = Tarif::where('parent_id', $parentId)->orderBy('number', 'ASC')->get();

    foreach ($anak as $index => $anaktarif) {
        $newChildNumber = $parentNumber . '.' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);

        // Update child
        $anaktarif->opd_id = $opdId;
        $anaktarif->uppd_id = $uppdId;
        $anaktarif->golongan_id = $golonganId;
        $anaktarif->jenis_id = $jenisId;
        $anaktarif->number = $newChildNumber;
        $anaktarif->update();

        // Jika child ini adalah "header", panggil fungsi rekursif untuk anak-anaknya
        if ($anaktarif->tipe == 'header') {
           $this->updateChildNumber($anaktarif->id, $newChildNumber,$opdId, $uppdId, $golonganId, $jenisId);
        }
    }
}


    public function update(Request $request,$id)
    {
        $tarif=Tarif::find($id);
            $tarif->uraian=$request->uraian;
            $tarif->keterangan=$request->keterangan;
          
            $tarif->update();

            return back()->with(['status' => 'success', 'message' => 'Operation successful']);



    }

    function mutasi()
    {
        $id=[];
        $id=[45,46,47,48,49,50,216];
        // $id=[163,164,165,166,167,168,231];
        // $id=[10,11];
        // $tarif=Tarif::whereIn('uppd_id',$id)->update(['opd_id' => 41]);
        $balai=Uppd::whereIn('id',$id)->update(['opd_id' => 3]);
    
return $balai;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
