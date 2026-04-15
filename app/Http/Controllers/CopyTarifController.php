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
use App\Models\PengajuanOpd;
use App\Models\Riwayat;
use App\Models\Tarif;
use App\Models\UsulanTarif;
use App\Models\TA;
use App\Models\TahunUsulan;
use carbon\carbon;

class CopyTarifController extends Controller
{
    public function headerUsulan(Request $request,$id) 
    {
        
        if ($request->subheader == '0' ) {
            $number=UsulanTarif::where('opd_id',$request->opd_id)
            ->where('uppd_id',$request->uppd_id)
            ->where('golongan_id',$request->gol_id)
            ->where('jenis_id',$request->jenis_id)
            ->where('parent_id',0)
            ->orderBy('number','DESC')->value('number');
            $nomer=$number+1;
            $newNumber = str_pad($nomer, 2, '0', STR_PAD_LEFT);
            }else{
    
                $number=UsulanTarif::where('parent_id',$request->subheader)->orderBy('number','DESC')->value('number');
                if ($number) {
                    // Pisahkan string berdasarkan titik
                    $parts = explode('.', $number);
                    
                    // Ambil angka terakhir, ubah ke integer, lalu tambahkan 1
                    $nomer = intval(array_pop($parts)) + 1;
                    
                    $lastNumber = str_pad($nomer, 2, '0', STR_PAD_LEFT);
                    // Gabungkan kembali dengan titik
                    $newNumber = implode('.', $parts) . '.' . $lastNumber;
                } else {
                    // Jika tidak ada number sebelumnya, atur nilai default
                    $parent=UsulanTarif::find($request->subheader);
                    $newNumber = $parent.'01';
                }
            }
            
            $tarif = UsulanTarif::find($id);
            $newTarif=new UsulanTarif();
            $newTarif->tarif_id=0;
            $newTarif->grms_id=$tarif->grms_id;
            $newTarif->ta_id=$tarif->ta_id;
            $newTarif->tu_id=$tarif->tu_id;
            $newTarif->tipe=$tarif->tipe;
            $newTarif->number=$newNumber;
            $newTarif->uraian=$tarif->uraian;
            $newTarif->satuan_id=$tarif->satuan_id;
            $newTarif->tarif_sarana=0;
            $newTarif->tarif_layanan=0;
            $newTarif->parent_id=$request->subheader;
            $newTarif->tahun=$tarif->tahun;
            $newTarif->opd_id=$request->opd_id;
            $newTarif->uppd_id=$request->uppd_id;
            $newTarif->ujang_id=$request->uppd_id;
            $newTarif->golongan_id=$request->gol_id;
            $newTarif->jenis_id=$request->jenis_id;
            $newTarif->rekening_id=$tarif->rekening_id;
            $newTarif->status= $tarif->status;
            $newTarif->nilai=0;
            $newTarif->bkn_nilai=$tarif->bkn_nilai;
            $newTarif->format_tarif=$tarif->format_tarif;
            $newTarif->open=$tarif->open;
            $newTarif->u_format=$tarif->u_format;
            $newTarif->keterangan=$tarif->keterangan;
            $newTarif->u_sarana=$tarif->u_sarana;
            $newTarif->u_layanan=$tarif->u_layanan;
            $newTarif->u_nilai=$tarif->u_nilai;
            $newTarif->save();
           
            
            // Perbarui semua anak secara rekursif
            $this->updateChildNumber($tarif->id, $newTarif->id, $newNumber, $request->opd_id,$request->uppd_id, $request->gol_id, $request->jenis_id);
            
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
    }

    function updateChildNumber($oldParent, $parentId, $parentNumber, $opdId, $uppdId, $golonganId, $jenisId)
{
    $anak = UsulanTarif::where('parent_id', $oldParent)->orderBy('number', 'ASC')->get();
    // $newParent = UsulanTarif::find( $parentId);

    foreach ($anak as $index => $anaktarif) {
        $newChildNumber = $parentNumber . '.' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);
        if ($anaktarif->tipe =='header') {
           $grms_id=0;
        }else{
            $lastkode=UsulanTarif::max('grms_id');

            $grms_id=$lastkode+1;
        }

        $newChildTarif=new UsulanTarif();
        $newChildTarif->tarif_id=0;
        $newChildTarif->grms_id=$grms_id;
        $newChildTarif->ta_id=$anaktarif->ta_id;
        $newChildTarif->tu_id=$anaktarif->tu_id;
        $newChildTarif->tipe=$anaktarif->tipe;
        $newChildTarif->number=$newChildNumber;
        $newChildTarif->uraian=$anaktarif->uraian;
        $newChildTarif->satuan_id=$anaktarif->satuan_id;
        $newChildTarif->tarif_sarana=0;
        $newChildTarif->tarif_layanan=0;
        $newChildTarif->parent_id=$parentId;
        $newChildTarif->tahun=$anaktarif->tahun;
        $newChildTarif->opd_id=$opdId;
        $newChildTarif->uppd_id=$uppdId;
        $newChildTarif->ujang_id=$uppdId;
        $newChildTarif->golongan_id=$golonganId;
        $newChildTarif->jenis_id=$jenisId;
        $newChildTarif->rekening_id=$anaktarif->rekening_id;
        $newChildTarif->status= $anaktarif->status;
        $newChildTarif->nilai=0;
        $newChildTarif->bkn_nilai=$anaktarif->bkn_nilai;
        $newChildTarif->format_tarif=$anaktarif->format_tarif;
        $newChildTarif->open=$anaktarif->open;
        $newChildTarif->u_format=$anaktarif->u_format;
        $newChildTarif->keterangan=$anaktarif->keterangan;
        $newChildTarif->u_sarana=$anaktarif->u_sarana;
        $newChildTarif->u_layanan=$anaktarif->u_layanan;
        $newChildTarif->u_nilai=$anaktarif->u_nilai;
        $newChildTarif->save();

        // Jika child ini adalah "header", panggil fungsi rekursif untuk anak-anaknya
        if ($anaktarif->tipe == 'header') {
           $this->updateChildNumber($anaktarif->id, $newChildTarif->id, $newChildNumber, $opdId, $uppdId, $golonganId, $jenisId);
        }
    }
}

public function childUsulan(Request $request, $id)
{
    $number=UsulanTarif::where('parent_id',$request->subheader)->orderBy('number','DESC')->value('number');
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
        $parent=UsulanTarif::find($request->subheader);
        $newNumber = $parent.'01';
    }
    
    $tarif=UsulanTarif::find($id);

    $lastkode=UsulanTarif::max('grms_id');
    $grms_id=$lastkode+1;

    $newChildTarif=new UsulanTarif();
    $newChildTarif->tarif_id=0;
    $newChildTarif->grms_id=$grms_id;
    $newChildTarif->ta_id=$tarif->ta_id;
    $newChildTarif->tu_id=$tarif->tu_id;
    $newChildTarif->tipe=$tarif->tipe;
    $newChildTarif->number=$newNumber;
    $newChildTarif->uraian=$tarif->uraian;
    $newChildTarif->satuan_id=$tarif->satuan_id;
    $newChildTarif->tarif_sarana=0;
    $newChildTarif->tarif_layanan=0;
    $newChildTarif->parent_id=$request->subheader;
    $newChildTarif->tahun=$tarif->tahun;
    $newChildTarif->opd_id=$request->opd_id;
    $newChildTarif->uppd_id=$request->uppd_id;
    $newChildTarif->ujang_id=$request->uppd_id;
    $newChildTarif->golongan_id=$request->gol_id;
    $newChildTarif->jenis_id=$request->jenis_id;
    $newChildTarif->rekening_id=$tarif->rekening_id;
    $newChildTarif->status= $tarif->status;
    $newChildTarif->nilai=0;
    $newChildTarif->bkn_nilai=$tarif->bkn_nilai;
    $newChildTarif->format_tarif=$tarif->format_tarif;
    $newChildTarif->open=$tarif->open;
    $newChildTarif->u_format=$tarif->u_format;
    $newChildTarif->keterangan=$tarif->keterangan;
    $newChildTarif->u_sarana=$tarif->u_sarana;
    $newChildTarif->u_layanan=$tarif->u_layanan;
    $newChildTarif->u_nilai=$tarif->u_nilai;
    $newChildTarif->save();


    return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);



    // return $parent;
}
public function getHeaders(Request $request)
{
    $headers = UsulanTarif::where('tipe', 'header')
        ->where('opd_id',$request->opd_id)
        ->where('uppd_id', $request->uppd_id)
        ->where('golongan_id', $request->gol_id)
        ->where('jenis_id', $request->jenis_id)
        ->get();

    return response()->json($headers);
}
}
