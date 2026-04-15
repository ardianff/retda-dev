<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;
use App\Models\Uppd;
use App\Models\User;
use Carbon\carbon;

class UppdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->opd) {
            
            $id_opd=$request->opd;
        }else{

            $id_opd=0;
        }
        $opd=Opd::all();
        return view('uppd.index',compact('opd','id_opd'));
    }

    /**
     * Show the form for creating a new resource.
     */

     function data($id)
     {

        $data=Uppd::where('level',2);
        if ($id != 0) {
           $data->where('opd_id',$id);
        }
        $uppd=$data->orderBy('kode','ASC');

        return datatables()
            ->of($uppd)
            ->addIndexColumn()

            ->addColumn('status', function ($uppd){
                $status = ($uppd->status == 'Aktif' ? '<span onclick="status(`'. route('uppd.aktif', $uppd->id) .'`)" class="btn btn-success btn-xs" > Aktif</span>' : '<span onclick="status(`'. route('uppd.aktif', $uppd->id) .'`)" class="btn btn-danger btn-xs" >Non Aktif</span>');
                return $status;
            })
            ->addColumn('opd', function ($uppd) {
                return $uppd->opd->singkatan ?? '';
            })
            ->addColumn('singkatan', function ($uppd) {
                return $uppd->singkatan ?? '';
            })
            ->addColumn('aksi', function ($uppd) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('uppd.update', $uppd->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-pen-alt    "></i></button>
                    <button type="button" onclick="deleteData(`'. route('uppd.destroy', $uppd->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi','opd','status','singkatan'])
            ->make(true);
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
        $tgl_aktif = ($request->tgl_aktif != null ? carbon::createFromFormat('d-m-Y', trim($request->tgl_aktif))->format('Y-m-d') : null);
        
        $tgl_nonaktif = ($request->tgl_nonaktif != null ? carbon::createFromFormat('d-m-Y', trim($request->tgl_nonaktif))->format('Y-m-d'):null);
        $uppd= new Uppd();
        $uppd->kode = $request->kode;
        $uppd->opd_id = $request->opd_id;
        $uppd->level = '2';
        $uppd->nama = $request->nama;
        $uppd->singkatan = $request->singkatan;
        $uppd->id_penari = $request->id_penari ??0;
        $uppd->id_grms = $request->id_grms??0;
        $uppd->tgl_aktif = $tgl_aktif;
        $uppd->tgl_nonaktif = $tgl_nonaktif;
        $uppd->status = $request->status;
        $uppd->save();

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $uppd = Uppd::find($id);
        return response()->json($uppd);
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
        // return $request;
        $tgl_aktif = ($request->tgl_aktif != null ? carbon::createFromFormat('d-m-Y', trim($request->tgl_aktif))->format('Y-m-d') : null);
        
        $tgl_nonaktif = ($request->tgl_nonaktif != null ? carbon::createFromFormat('d-m-Y', trim($request->tgl_nonaktif))->format('Y-m-d'):null);
        
        $uppd=Uppd::find($id);
        $uppd->kode = $request->kode;
        $uppd->opd_id = $request->opd_id;
        $uppd->level = '2';
        $uppd->nama = $request->nama;
        $uppd->singkatan = $request->singkatan;
        $uppd->id_penari = $request->id_penari;
        $uppd->id_grms = $request->id_grms;
        $uppd->tgl_aktif = $tgl_aktif;
        $uppd->tgl_nonaktif = $tgl_nonaktif;
        $uppd->status = $request->status;
        $uppd->update();
        return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }

    function aktif($id) 
    {
        $uppd=Uppd::find($id);
        if ($uppd->status == 'Aktif') {
        $sat=Uppd::find($id);
            $sat->status='Non Aktif';
            $sat->update();
        }else{
        $sat=Uppd::find($id);

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
        $cek=Tarif::where('uppd_id',$id)->first();
        $cek2=UsulanTarif::where('uppd_id',$id)->first();
        if ($cek && $cek2 ) {
            return response()->json(['message' => 'Data tidak dapat dihapus karena masih terkait'], 400);
        }
    $opd=Opd::find($id)->delete();
    }
}
