<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pejabat;
use App\Models\TA;
use App\Models\Opd;
use App\Models\Uppd;
use App\Models\User;

class PejabatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        if (auth()->user()->level == 5) {
            $uppdall=Uppd::where('id',auth()->user()->uppd_id)->get();
            $opdall=Opd::where('id',auth()->user()->opd_id)->get();
            $opd=auth()->user()->opd_id;
            $uppd=auth()->user()->uppd_id;
            
    
         }
         elseif (auth()->user()->level == 4) {
             $uppdall=Uppd::where('id',auth()->user()->uppd_id)->get();
            $opdall=Opd::where('id',auth()->user()->opd_id)->get();
            $opd=auth()->user()->opd_id;
            $uppd=auth()->user()->uppd_id;
            
         }
         elseif (auth()->user()->level == 3) {
             $uppdall=Uppd::where('opd_id',auth()->user()->opd_id)->get();
            $opdall=Opd::where('id',auth()->user()->opd_id)->get();
            $opd=auth()->user()->opd_id;
            $uppd=$request->uppd_id??0;
            
         }
         elseif (auth()->user()->level == 2) {
            if ($request->opd_id) {
                $uppdall=Uppd::where('opd_id',$request->opd_id)->get();
            }else{
    
                $uppdall=Uppd::all();
            }
            $opdall=Opd::all();
            $opd=$request->opd_id??auth()->user()->opd_id;
            $uppd=$request->uppd_id??0;
            
         }
         elseif (auth()->user()->level == 1) {
            if ($request->opd_id) {
                $uppdall=Uppd::where('opd_id',$request->opd_id)->get();
            }else{
    
                $uppdall=Uppd::all();
            }
            $opdall=Opd::all();
            $opd=$request->opd_id??0;
            $uppd=$request->uppd_id??0;
            
         }
         elseif (auth()->user()->level == 6) {
            if ($request->opd_id) {
                $uppdall=Uppd::where('opd_id',$request->opd_id)->get();
            }else{
    
                $uppdall=Uppd::all();
            }
            $opdall=Opd::all();
            $opd=$request->opd_id??auth()->user()->opd_id;
            $uppd=$request->uppd_id??auth()->user()->uppd_id;

         }
            $thn_id=$request->thn_id;
            
            $pejabat=Pejabat::where('uppd_id',$request->uppd_id)->first();
            // $pejabat2=Pejabat::where('tahun',$request->thn_id)->where('uppd_id',$request->uppd_id)->where('number',2)->first();
            
            
            $tahunall=TA::all();
           
// return $pejabat1;
        return view('pejabat.index',compact('tahunall','opdall','uppdall','thn_id','opd','uppd','pejabat'));
    }

    public function view()
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
       
        return view('pejabat.view',compact('opd','uppd'));
    }

    /**
     * Show the form for creating a new resource.
     */

     
     public function jenis($pejabat)
     {
         $jenis = Jenis::where('pejabat_id', $pejabat)->get();
         return response()->json($jenis);
     }
 

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        
        $cek=Pejabat::where('opd_id',$request->opd)->where('uppd_id',$request->uppd)->first();
        if ($cek) {
            $pejabat=Pejabat::find($cek->id);
            $pejabat->opd_id = $request->opd;
            $pejabat->uppd_id = $request->uppd;
            $pejabat->nama = $request->nama;
            $pejabat->kota = $request->kota;
            $pejabat->antr_waktu = $request->antr_waktu;
            $pejabat->jabatan = $request->jabatan;
            $pejabat->jabatan_utama = $request->jabatan_utama ?? null;
            $pejabat->pangkat = $request->pangkat;
            $pejabat->nip = $request->nip;
            $pejabat->status = $request->status;
            $pejabat->update();
        }else{
            $pejabat=new Pejabat();
            $pejabat->opd_id = $request->opd;
            $pejabat->uppd_id = $request->uppd;
            $pejabat->tahun = $request->tahun;
            $pejabat->nama = $request->nama;
            $pejabat->kota = $request->kota;

            $pejabat->antr_waktu = $request->antr_waktu;
            $pejabat->jabatan = $request->jabatan;
            $pejabat->jabatan_utama = $request->jabatan_utama ?? null;
            $pejabat->pangkat = $request->pangkat;
            $pejabat->nip = $request->nip;
            $pejabat->tahun = $request->tahun;
            $pejabat->status = $request->status;
            $pejabat->save();
        }

      
        return redirect()->route('pejabat.index', [
            'opd_id' => $pejabat->opd_id, 
            'uppd_id' => $pejabat->uppd_id, 
            'thn_id' => $pejabat->tahun
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $pejabat = Pejabat::find($id);
        return response()->json($pejabat);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $pejabat = Pejabat::find($id)->update($request->all());

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
