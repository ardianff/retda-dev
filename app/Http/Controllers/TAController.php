<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TA;
use App\Models\User;
use App\Models\Pengajuan;
use App\Models\TahunUsulan;
use App\Models\UsulanTarif;
use App\Models\Tarif;

class TAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('TA.index');
    }

    /**
     * Show the form for creating a new resource.
     */

     function data()
     {

        $TA=TA::all();

        return datatables()
            ->of($TA)
            ->addIndexColumn()


            ->addColumn('aksi', function ($TA) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('TA.update', $TA->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-pen-alt    "></i></button>
                    <button type="button" onclick="deleteData(`'. route('TA.destroy', $TA->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
     }



    public function create()
    {
        $usulan=TahunUsulan::where('status',1)->first();
        return view('TA.penetapan',compact('usulan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       
        $usulan=TahunUsulan::find($request->tu_id);
        $TA= new TA();
        $TA->pengajuan_id = $pengajuan->id;
        $TA->tu_id = $usulan->id;
        $TA->tahun = $request->tahun;
        $TA->user_id = auth()->user()->id;
        $TA->deskripsi = $request->deskripsi;
        $TA->perihal = $request->perihal;
        $TA->tgl_terbit = $request->tgl_terbit;
        $TA->tgl_berlaku = $request->tgl_berlaku;
        $TA->status = 'Aktif';
        $TA->save();
        $cek=TA::where('id','!=',$TA->id)->get();
         if ($cek) {
            # code...
            foreach ($cek as $key => $value) {
                $ajuan=TA::find($value->id);
                $ajuan->status=0;
                $ajuan->update();
            }
        }

        $trf=UsulanTarif::with('satuan')->where('tu_id',$request->tu_id)->get();
        $idMapping = [];
        foreach ($trf as $value) {
           
            $tarif=new Tarif();
            // $tarif->tarif_id=$value->id;
            $tarif->grms_id=$value->grms_id??0;
            $tarif->tipe=$value->tipe;
            $tarif->number=$value->number;
            $tarif->uraian=$value->uraian;
            $tarif->satuan_id=$value->satuan_id;
            $tarif->nama_satuan=$value->satuan->uraian??0;
            $tarif->parent_id=0;
            $tarif->tahun=$TA->tahun;
            $tarif->ta_id=$TA->id;
            $tarif->opd_id=$value->opd_id;
            $tarif->uppd_id=$value->uppd_id;
            $tarif->ujang_id=$value->ujang_id;
            $tarif->golongan_id=$value->golongan_id;
            $tarif->jenis_id=$value->jenis_id;
            $tarif->rekening_id=$value->rekening_id;
            $tarif->status=$value->status;
            $tarif->tarif_sarana=$value->u_sarana;
            $tarif->tarif_layanan=$value->u_layanan;
            $tarif->nilai=$value->u_nilai;
            $tarif->bukan_nilai=$value->bukan_nilai;
            $tarif->up=$value->up;
            $tarif->open=$value->open;
            $tarif->keterangan=$value->keterangan;
            $tarif->save();

            $idMapping[$value->id] = $tarif->id;
        }
        
        // **Loop kedua: Perbarui parent_id di UsulanTarif**
        foreach ($trf as $value) {
            if ($value->parent_id) {
                Tarif::where('id', $value->id)->update([
                    'parent_id' => $idMapping[$value->parent_id] ?? 0
                ]);
            }
            }

        $tutup=TahunUsulan::find($request->tu_id)->update([
            'status'=> 0,
        ]);
        return redirect()->route('TA.index')->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $TA = TA::find($id);
        return response()->json($TA);
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
        $TA = TA::find($id)->update($request->all());

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }

    
}
