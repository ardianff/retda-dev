<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;
use App\Models\TA;
use App\Models\Uppd;
use App\Models\Satker;
use App\Models\User;
use Carbon\carbon;

class OpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('opd.index');
    }

    /**
     * Show the form for creating a new resource.
     */

     function data()
     {

        $opd=Opd::all();

        return datatables()
            ->of($opd)
            ->addIndexColumn()
            ->addColumn('status', function ($opd){
                $status = ($opd->status == 'Aktif' ? '<span  class="btn btn-success btn-xs" > '.$opd->status.'</span>' : '<span  class="btn btn-danger btn-xs" >'.$opd->status.'</span>');
                return $status;
            })
            ->addColumn('tgl_aktif', function ($opd){
                $tgl_aktif = ($opd->tgl_aktif != null ? tanggal($opd->tgl_aktif) : '');

                return $tgl_aktif;
            })
            ->addColumn('tgl_nonaktif', function ($opd){

                $tgl_nonaktif = ($opd->tgl_nonaktif != null ? tanggal($opd->tgl_nonaktif) : '');

                return $tgl_nonaktif;
            })

            ->addColumn('aksi', function ($opd) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('opd.update', $opd->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-pen-alt    "></i></button>
                    <button type="button" onclick="deleteData(`'. route('opd.destroy', $opd->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi','status'])
            ->make(true);
     }



    public function masuk()
    {
      $opd=Opd::all();
      foreach ($opd as $value) {
       
        $uppd= new Uppd();
        $uppd->kode = $value->kode;
        $uppd->opd_id = $value->id;
        $uppd->level = '1';
        $uppd->nama = $value->opd;
        $uppd->singkatan = $value->singkatan;
        $uppd->id_penari = $value->id_penari;
        $uppd->id_grms = $value->id_grms;
        $uppd->save();
        }
        $upt=Uppd::where('level',1)->get();
        return $upt;
    }

    public function uppd($opd_id)
    {
        $allowedLevels = [1, 2, 3, 6];
    
    if (!in_array(auth()->user()->level, $allowedLevels)) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    $uppd = Uppd::where('opd_id', $opd_id)->where('status', 'Aktif')->orderBy('level','ASC')->get();

        return response()->json($uppd);
    }

    public function getuppd($opd_id)
    {
       
    $uppd = Uppd::where('opd_id', $opd_id)->where('status', 'Aktif')->orderBy('level','ASC')->get();

        return response()->json($uppd);
    }


    public function tahunAktif($id) 
    {
        $year = TA::find($id)->value('tahun');

        $opd = Opd::where('tgl_aktif', '<=', $year . '-12-31')
            ->where(function ($query) use ($year) {
                $query->whereNull('tgl_nonaktif')
                    ->orWhere('tgl_nonaktif', '>=', $year . '-01-01');
            })
            ->get();
            return response()->json($opd);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tgl_aktif = ($request->tgl_aktif != null ? Carbon::createFromFormat('d-m-Y', trim($request->tgl_aktif))->format('Y-m-d') : null);
        
        $tgl_nonaktif = ($request->tgl_nonaktif != null ? Carbon::createFromFormat('d-m-Y', trim($request->tgl_nonaktif))->format('Y-m-d'):null);

        $opd= new Opd();
        $opd->opd = $request->opd;
        $opd->singkatan = $request->singkatan??null;
        $opd->kode = $request->kode??null;
        $opd->id_penari = $request->id_penari??null;
        $opd->id_grms = $request->id_grms??null;
        $opd->tgl_aktif = $tgl_aktif??null;
        $opd->tgl_nonaktif = $tgl_nonaktif??null;
        $opd->status = $request->status??null;
        $opd->save();

        $uppd= new Uppd();
        $uppd->kode = $request->kode??null;
        $uppd->opd_id = $opd->id;
        $uppd->level = '1';
        $uppd->nama = $request->opd;
        $uppd->singkatan = $request->singkatan;
        $opd->id_penari = $request->id_penari??null;
        $opd->id_grms = $request->id_grms??null;
        $opd->tgl_aktif = $tgl_aktif??null;
        $opd->tgl_nonaktif = $tgl_nonaktif??null;
        $opd->status = $request->status??null;
        $uppd->save();

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $opd = Opd::find($id);
        return response()->json($opd);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function mutasi()
    {
     $satker = Satker::all();

foreach ($satker as $value) {
    $uppd = Uppd::where('id_grms', $value->grms_id)->first();

    if ($uppd) { // ✅ hanya update kalau data ditemukan
        $uppd->update([
            'id_grms' => $value->grms_baru,
            'status'  => $value->status,
        ]);
    }
}

return "Update selesai";

    }   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $tgl_aktif = ($request->tgl_aktif != null ? Carbon::createFromFormat('d-m-Y', trim($request->tgl_aktif))->format('Y-m-d') : null);
        
        $tgl_nonaktif = ($request->tgl_nonaktif != null ? Carbon::createFromFormat('d-m-Y', trim($request->tgl_nonaktif))->format('Y-m-d'):null);
        
        $opd= Opd::find($id);
        $opd->opd = $request->opd;
        $opd->singkatan = $request->singkatan;
        $opd->kode = $request->kode;
        $opd->id_penari = $request->id_penari;
        $opd->id_grms = $request->id_grms;
        $opd->tgl_aktif = $tgl_aktif;
        $opd->tgl_nonaktif = $tgl_nonaktif;
        $opd->status = $request->status;
        $opd->update();
        $balai=Uppd::where('level',1)->where('opd_id',$id)->first();
        $balai->kode = $request->kode;
        $balai->nama = $request->opd;
        $balai->singkatan = $request->singkatan;
        $balai->id_penari = $request->id_penari;
        $balai->id_grms = $request->id_grms;
        $balai->update();

        $upt=Uppd::where('opd_id',$id)->get();
        foreach ($upt as $value) {
            $uppd=Uppd::find($value->id);
            $uppd->tgl_aktif = $tgl_aktif;
            $uppd->tgl_nonaktif = $tgl_nonaktif;
            $uppd->status = $request->status;
            $uppd->update();
        }

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }

    function aktif($id) 
    {
        $opd=Opd::find($id);
        if ($opd->status == 'Aktif') {
        $sat=Opd::find($id);
            $sat->status='Non Aktif';
            $sat->update();
        }else{
        $sat=Opd::find($id);

            $sat->status='Aktif';
            $sat->update();

        }

       return response()->json();

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cek=Tarif::where('opd_id',$id)->first();
        $cek2=UsulanTarif::where('opd_id',$id)->first();
        $cek3=Uppd::where('opd_id',$id)->where('level',2)->first();
        if ($cek && $cek2 && $cek3) {
            return response()->json(['message' => 'Data tidak dapat dihapus karena masih terkait'], 400);
        }
    $uppd=Uppd::find($id)->delete();
    
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
