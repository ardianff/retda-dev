<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\PengajuanOpd;
use App\Models\TA;
use App\Models\Opd;
use App\Models\TahunUsulan;
use App\Models\Tarif;
use App\Models\UsulanTarif;
use App\Models\User;
use Carbon\Carbon;
class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $thn=TahunUsulan::where('status',1)->get();
        $opd=Opd::all();
        return view('pengajuan.index',compact('thn','opd'));
    }

    /**
     * Show the form for creating a new resource.
     */

     function data()
     {

        $pengajuan=Pengajuan::all();

        return datatables()
            ->of($pengajuan)
            ->addIndexColumn()
            ->addColumn('status', function ($pengajuan) {
                $status = ($pengajuan->status == 1 ? 
                '<a onclick="updateStatus(`'.$pengajuan->id.'`,0)"  class="btn btn-success btn-xs" ><i class="fas fa-check-circle"></i> </a>' : 
                '<a onclick="updateStatus(`'.$pengajuan->id.'`,1)" class="btn btn-danger btn-xs" ><i class="far fa-times-circle"></i></a>');
                return $status;
            })
           
            ->addColumn('aksi', function ($pengajuan) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('pengajuan.update', $pengajuan->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-pen-alt    "></i></button>
                   
                </div>
                ';
            })
            ->rawColumns(['aksi','status','tahun'])
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
        $tanggal_awal = Carbon::createFromFormat('d-F-Y', trim($request->tgl_awal))->format('Y-m-d');

        $tanggal_akhir = Carbon::createFromFormat('d-F-Y', trim($request->tgl_akhir))->format('Y-m-d');
       $tahun=TahunUsulan::find($request->tahun);
        $pengajuan= new Pengajuan();
        $pengajuan->tgl_awal = $tanggal_awal;
        $pengajuan->tgl_akhir = $tanggal_akhir;
        $pengajuan->ta_id = $tahun->ta_id;
        $pengajuan->tu_id = $tahun->id;
        $pengajuan->tahun = $tahun->tahun;
        $pengajuan->pilihan = $request->pilih_opd;
        $pengajuan->deskripsi = $request->deskripsi;
        $pengajuan->status = 1;
        $pengajuan->save();
         $peng=Pengajuan::where('id','!=',$pengajuan->id)->get();
         if ($peng) {
            # code...
            foreach ($peng as $key => $value) {
                $ajuan=Pengajuan::find($value->id);
                $ajuan->status=0;
                $ajuan->update();
            }
        }
        if ($request->has('opd_id')) {
            $pengajuanOPD = [];
            foreach ($request->opd_id as $opdID) {
                $pengajuanOPD[] = [
                    'pengajuan_id' => $pengajuan->id,
                    'opd_id' => $opdID,
                ];
            }
            PengajuanOpd::insert($pengajuanOPD);
        }
        

// $tarif=UsulanTarif::where('tu_id',$request->tahun)->update(['pengajuan_id'=>$pengajuan->id]);
     
        return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $pengajuan = Pengajuan::with('pengajuanOpd')->find($id);
        $selectedOpd = $pengajuan->pengajuanOpd->pluck('opd_id')->toArray();
    
    return response()->json([
        'pengajuan' => $pengajuan,
        'selectedOpd' => $selectedOpd, // Kirim daftar OPD yang sudah dipilih
    ]);
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
        $tanggal_awal = Carbon::createFromFormat('d-F-Y', trim($request->tgl_awal))->format('Y-m-d');
        
        $tanggal_akhir = Carbon::createFromFormat('d-F-Y', trim($request->tgl_akhir))->format('Y-m-d');
        // return $tanggal_awal;
        $pengopd=PengajuanOpd::where('pengajuan_id',$id)->delete();
        $pengajuan = Pengajuan::find($id);
        $pengajuan->deskripsi=$request->deskripsi;
        $pengajuan->pilihan=$request->pilih_opd;
        $pengajuan->tgl_awal=$tanggal_awal;
        $pengajuan->tgl_akhir=$tanggal_akhir;
        $pengajuan->update();

        if ($request->has('opd_id')) {
            $pengajuanOPD = [];
            foreach ($request->opd_id as $opdID) {
                $pengajuanOPD[] = [
                    'pengajuan_id' => $pengajuan->id,
                    'opd_id' => $opdID,
                ];
            }
            PengajuanOpd::insert($pengajuanOPD);
        }
        // return response()->json($pengajuan);

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }

    public function updateStatus(Request $request)
    {
        $pengajuan = Pengajuan::find($request->id);
    if ($pengajuan) {
        $pengajuan->status = $request->status;
        $pengajuan->update();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);
    }

    return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
