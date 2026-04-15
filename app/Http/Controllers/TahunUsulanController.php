<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\TA;
use App\Models\TahunUsulan;
use App\Models\Tarif;
use App\Models\UsulanTarif;
use App\Models\User;
use Carbon\Carbon;
class TahunUsulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $thn=TA::all();
        $usulan=TahunUsulan::all();
        return view('tahun-usulan.index',compact('thn','usulan'));
    }

    /**
     * Show the form for creating a new resource.
     */

    
    

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $thn=TA::find($request->tahun);
       $usulke=TahunUsulan::count();
       $kode=tambah_nol_didepan($usulke,2).date('d.m').$thn->tahun;
        $tu= new TahunUsulan();
        $tu->ta_id = $thn->id;
        $tu->tahun = $thn->tahun;
        $tu->kode =   $kode;
        $tu->deskripsi = $request->deskripsi;
        $tu->status = 1;
        $tu->user_id = auth()->user()->id;
        $tu->save();

    //     $trf=Tarif::where('ta_id',$request->tahun)->get();
    //     $idMapping = [];
    //     foreach ($trf as $value) {
           
    //         $tarif=new UsulanTarif();
    //         $tarif->tarif_id=$value->id;
    //         $tarif->grms_id=$value->grms_id??0;
    //         $tarif->ta_id=$value->ta_id;
    //         $tarif->tu_id=$tu->id;
    //         $tarif->tipe=$value->tipe;
    //         $tarif->number=$value->number;
    //         $tarif->uraian=$value->uraian;
    //         $tarif->satuan_id=$value->satuan_id;;
    //         $tarif->tarif_sarana=$value->tarif_sarana;
    //         $tarif->tarif_layanan=$value->tarif_layanan;
    //         $tarif->tahun=$value->tahun;
    //         $tarif->parent_id=0;
    //         $tarif->opd_id=$value->opd_id;
    //         $tarif->uppd_id=$value->uppd_id;
    //         $tarif->ujang_id=$value->ujang_id;
    //         $tarif->golongan_id=$value->golongan_id;
    //         $tarif->jenis_id=$value->jenis_id;
    //         $tarif->rekening_id=$value->rekening_id;
    //         $tarif->status=$value->status;
    //         $tarif->nilai=$value->nilai;
    //         $tarif->bukan_nilai=$value->bukan_nilai;
    //         $tarif->tipe=$value->tipe;
    //         $tarif->open=$value->open;
    //         $tarif->up=$value->up;
    //         $tarif->u_sarana=$value->tarif_sarana;
    //         $tarif->u_layanan=$value->tarif_layanan;
    //         $tarif->u_nilai=$value->nilai;
    //         $tarif->save();

    //         $idMapping[$value->id] = $tarif->id;
    //     }
        
    //     // **Loop kedua: Perbarui parent_id di UsulanTarif**
    //     foreach ($trf as $value) {
    //         if ($value->parent_id) {
    //             UsulanTarif::where('tarif_id', $value->id)->update([
    //                 'parent_id' => $idMapping[$value->parent_id] ?? 0
    //             ]);
    //         }
    //         }


    //     return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    // Ambil data Tarif sesuai tahun
$trf = Tarif::where('ta_id', $request->tahun)->get();
$idMapping = [];

// Loop pertama: Proses data yang parent_id == 0 (header)
foreach ($trf->where('parent_id', 0) as $value) {
    $tarif = new UsulanTarif();
    $tarif->tarif_id       = $value->id;
    $tarif->grms_id        = $value->grms_id ?? 0;
    $tarif->ta_id          = $value->ta_id;
    $tarif->tu_id          = $tu->id;
    $tarif->tipe           = $value->tipe;
    $tarif->number         = $value->number;
    $tarif->uraian         = $value->uraian;
    $tarif->satuan_id      = $value->satuan_id;
    $tarif->tarif_sarana   = $value->tarif_sarana;
    $tarif->tarif_layanan  = $value->tarif_layanan;
    $tarif->tahun          = $value->tahun;
    $tarif->parent_id      = 0; // pastikan ini header
    $tarif->opd_id         = $value->opd_id;
    $tarif->uppd_id        = $value->uppd_id;
    $tarif->ujang_id       = $value->ujang_id;
    $tarif->golongan_id    = $value->golongan_id;
    $tarif->jenis_id       = $value->jenis_id;
    $tarif->rekening_id    = $value->rekening_id;
    $tarif->status         = $value->status;
    $tarif->nilai          = $value->nilai;
    $tarif->bukan_nilai    = $value->bukan_nilai;
    $tarif->open           = $value->open;
    $tarif->up             = $value->up;
    $tarif->u_sarana       = $value->tarif_sarana;
    $tarif->u_layanan      = $value->tarif_layanan;
    $tarif->u_nilai        = $value->nilai;
    $tarif->save();

    // Simpan mapping dari tarif asli ke tarif usulan baru
    $idMapping[$value->id] = $tarif->id;
}

// Loop kedua: Proses data yang memiliki parent_id != 0 (anak)
foreach ($trf->where('parent_id', '!=', 0) as $value) {
    $tarif = new UsulanTarif();
    $tarif->tarif_id       = $value->id;
    $tarif->grms_id        = $value->grms_id ?? 0;
    $tarif->ta_id          = $value->ta_id;
    $tarif->tu_id          = $tu->id;
    $tarif->tipe           = $value->tipe;
    $tarif->number         = $value->number;
    $tarif->uraian         = $value->uraian;
    $tarif->satuan_id      = $value->satuan_id;
    $tarif->tarif_sarana   = $value->tarif_sarana;
    $tarif->tarif_layanan  = $value->tarif_layanan;
    $tarif->tahun          = $value->tahun;
    // Pastikan untuk meng-update parent_id menggunakan mapping; jika tidak ditemukan, default ke 0
    $tarif->parent_id      = isset($idMapping[$value->parent_id]) ? $idMapping[$value->parent_id] : 0;
    $tarif->opd_id         = $value->opd_id;
    $tarif->uppd_id        = $value->uppd_id;
    $tarif->ujang_id       = $value->ujang_id;
    $tarif->golongan_id    = $value->golongan_id;
    $tarif->jenis_id       = $value->jenis_id;
    $tarif->rekening_id    = $value->rekening_id;
    $tarif->status         = $value->status;
    $tarif->nilai          = $value->nilai;
    $tarif->bukan_nilai    = $value->bukan_nilai;
    $tarif->open           = $value->open;
    $tarif->up             = $value->up;
    $tarif->u_sarana       = $value->tarif_sarana;
    $tarif->u_layanan      = $value->tarif_layanan;
    $tarif->u_nilai        = $value->nilai;
    $tarif->save();

    // Simpan mapping untuk kemungkinan nested child lain
    $idMapping[$value->id] = $tarif->id;
}

return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $pengajuan = Pengajuan::with('tahun')->find($id);
        return response()->json($pengajuan);
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
        $pengajuan = Pengajuan::find($id);
        $pengajuan->tahun=$request->tahun;
        $pengajuan->tgl_awal=$tanggal_awal;
        $pengajuan->tgl_akhir=$tanggal_akhir;
        $pengajuan->update();
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
