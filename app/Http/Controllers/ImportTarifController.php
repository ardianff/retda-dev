<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;
use App\Models\UsulanTarif;
use App\Models\Importtarif;
use App\Models\Opd;
use App\Models\Uppd;
use App\Models\Golongan;
use App\Models\Jenis;
use App\Models\Rekening;
use App\Models\TA;
use App\Models\TahunUsulan;
use App\Models\Satuan;
use Illuminate\Support\Facades\Log;

use DiDom\Document;

use Illuminate\Support\Facades\DB;

class ImportTarifController extends Controller
{
    public function index()
    {
        $opd=Opd::all();
        $uppd=Uppd::all();
        $golongan=Golongan::all();
        $jenis=Jenis::all();
        $rekening=Rekening::all();
        return view('import_tarif',compact('opd','uppd','golongan','jenis','rekening'));
    }

    public function insertMaster()
    {
        $opd=Opd::all();
        $uppd=Uppd::all();
        $golongan=Golongan::all();
        $jenis=Jenis::all();
        return view('mutasi_tarif',compact('opd','uppd','golongan','jenis'));
    }

    public function insertUsulan()
    {
        $opd=Opd::all();
        $uppd=Uppd::all();
        $golongan=Golongan::all();
        $jenis=Jenis::all();
        return view('mutasi_usulan',compact('opd','uppd','golongan','jenis'));
    }

    public function mutasiTarif(Request $request)
    {
        $trf = Importtarif::where('ta_id', $request->ta_id)
        ->where('opd_id',$request->opd_id)
        ->where('uppd_id',$request->uppd_id)
        ->where('golongan_id',$request->golongan_id)
        ->where('jenis_id',$request->jenis_id)
        ->get();

        // return $trf;


        $idMapping = [];
        
        // Loop pertama: Proses data yang parent_id == 0 (header)
        foreach ($trf->where('parent_id', 0) as $value) {
            $tarif = new Tarif();
            $tarif->grms_id        = $value->grms_id ?? 0;
            $tarif->tipe           = $value->tipe;
            $tarif->number         = $value->number;
            $tarif->uraian         = $value->uraian;
            $tarif->satuan_id      = $value->satuan_id;
            $tarif->nama_satuan      = $value->nama_satuan;
            $tarif->tarif_sarana   = $value->tarif_sarana;
            $tarif->tarif_layanan  = $value->tarif_layanan;
            $tarif->parent_id      = 0; // pastikan ini header
            $tarif->tahun          = $value->tahun;
            $tarif->ta_id          = $request->ta_id;
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
            $tarif->keterangan     = $value->keterangan;
            $tarif->save();
        
            // Simpan mapping dari tarif asli ke tarif usulan baru
            $idMapping[$value->id] = $tarif->id;
        }
        
        // Loop kedua: Proses data yang memiliki parent_id != 0 (anak)
        foreach ($trf->where('parent_id', '!=', 0) as $value) {
            $tarif = new Tarif();
            $tarif->grms_id        = $value->grms_id ?? 0;
            $tarif->tipe           = $value->tipe;
            $tarif->number         = $value->number;
            $tarif->uraian         = $value->uraian;
            $tarif->satuan_id      = $value->satuan_id;
            $tarif->nama_satuan      = $value->nama_satuan;
            $tarif->tarif_sarana   = $value->tarif_sarana;
            $tarif->tarif_layanan  = $value->tarif_layanan;
           // Pastikan untuk meng-update parent_id menggunakan mapping; jika tidak ditemukan, default ke 0
           $tarif->parent_id      = isset($idMapping[$value->parent_id]) ? $idMapping[$value->parent_id] : 0;
            $tarif->tahun          = $value->tahun;
            $tarif->ta_id          = $request->ta_id;
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
            $tarif->keterangan     = $value->keterangan;
          
            $tarif->save();
        
            // Simpan mapping untuk kemungkinan nested child lain
            $idMapping[$value->id] = $tarif->id;
        }
        
        return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }

   
        public function store(Request $request)
        {
            // Validasi file dan input tambahan
            // $request->validate([
            //     'file' => 'required|mimes:txt|max:5120',
            //     'tahun' => 'required|integer',
            //     'ta_id' => 'required|integer',
            //     'opd_id' => 'required|integer',
            //     'uppd_id' => 'required|integer',
            //     'golongan_id' => 'required|integer',
            //     'jenis_id' => 'required|integer',
            //     'rekening_id' => 'required|integer',
            // ]);
    
            // Ambil input dari form
            $thn=TA::find($request->ta_id);
            $tahun = $thn->tahun;
            $ta_id = $thn->id;
            $opd_id = $request->opd_id;
            $uppd_id = $request->uppd_id;
            $golongan_id = $request->golongan_id;
            $jenis_id = $request->jenis_id;
            $rekening_id = $request->rekening_id;
    
            // Baca isi file
            $file = $request->file('file');
            $content = file_get_contents($file->getPathname());
    
            // Parsing HTML menggunakan DiDom
            $document = new Document($content);
            $rows = $document->find('tbody tr'); // Ambil semua baris dari tabel
    
            if (empty($rows)) {
                return back()->with('error', 'File tidak mengandung data tabel.');
            }

            DB::beginTransaction();
            try {
                $kodeMap = []; // Menyimpan ID berdasarkan kode unik
    
                foreach ($rows as $row) {
                    $columns = $row->find('td'); // Ambil semua kolom dalam baris
    
                    if (count($columns) < 9) continue; // Lewati jika kolom kurang dari 9
    
                    $kode = trim($columns[0]->text());
                    $deskripsi = trim($columns[1]->text());
                    $satuan_nama = trim($columns[2]->text());
                    $jasa_sarana = intval(str_replace(".", "", $columns[3]->text()));
                    $jasa_pelayanan = intval(str_replace(".", "", $columns[4]->text()));
                    $tarif_retribusi = intval(str_replace(".", "", $columns[5]->text()));
                    $status_text = trim($columns[7]->text());
                    $status = $status_text == 'Aktif' ? 1 : 0;
                    $kode_grms = trim($columns[8]->text());
                    $kode_grms = is_numeric($kode_grms) ? intval($kode_grms) : null;
                    
                    
                    
                    if ( $jenis_id==16) {
                        $nilai=$jasa_sarana+$jasa_pelayanan;
                    }else{
                        $nilai=$tarif_retribusi;
                    }
                    Log::info("Kode: $kode, Jasa Sarana: $jasa_sarana, Jasa Pelayanan: $jasa_pelayanan, Tarif Retribusi: $tarif_retribusi, Nilai: $nilai");

                    // Ambil atribut row-id dan parent-id untuk menentukan parent_id
                    $row_id = $row->attr('row-id');
                    $parent_id = $row->attr('parent-id') ?? 0;
    
                    // Jika parent_id ada, cari di kodeMap
                    $parent_id = $parent_id && isset($kodeMap[$parent_id]) ? $kodeMap[$parent_id] : 0;
    
                    // Cek satuan_id berdasarkan nama satuan
                    $satuan = Satuan::where('uraian', $satuan_nama)->first();
                    $satuan_id = $satuan ? $satuan->id : 0;
    
                    // Simpan ke database
                    $tarif = Importtarif::create([
                        'parent_id' => $parent_id,
                        'number' => $kode,
                        'uraian' => $deskripsi,
                        'tipe' => $kode_grms ? 'body' : 'header',
                        'satuan_id' => $satuan_id,
                        'nama_satuan' => $satuan_nama,
                        'tarif_sarana' => $jasa_sarana,
                        'tarif_layanan' => $jasa_pelayanan,
                        'nilai' => $nilai,
                        'status' => $status,
                        'grms_id' => $kode_grms,
                        'tahun' => $tahun,
                        'ta_id' => $ta_id,
                        'opd_id' => $opd_id,
                        'uppd_id' => $uppd_id,
                        'golongan_id' => $golongan_id,
                        'jenis_id' => $jenis_id,
                        'rekening_id' => $rekening_id,
                        'bukan_nilai' => null,
                        'open' => 0,
                        'up' => null,
                    ]);
    
                    // Simpan ID berdasarkan row-id
                    $kodeMap[$row_id] = $tarif->id;
                }
    
                DB::commit();
                return back()->with('success', 'Data berhasil diimport ke database!');
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function clone(Request $request) 
    {
        $trf=Tarif::where('ta_id',$request->tahun)->get();
        $idMapping = [];
        foreach ($trf as $value) {
           
            $tarif=new UsulanTarif();
            $tarif->tarif_id=$value->id;
            $tarif->grms_id=$value->grms_id;
            $tarif->pengajuan_id=$pengajuan->id;
            $tarif->ta_id=$value->ta_id;
            $tarif->tipe=$value->tipe;
            $tarif->number=$value->number;
            $tarif->uraian=$value->uraian;
            $tarif->satuan_id=$value->satuan_id;;
            $tarif->tarif_sarana=$value->tarif_sarana;;
            $tarif->tarif_layanan=$value->tarif_layanan;;
            $tarif->tahun=$value->tahun;
            $tarif->opd_id=$value->opd_id;
            $tarif->uppd_id=$value->uppd_id;
            $tarif->ujang_id=$value->ujang_id;
            $tarif->golongan_id=$value->golongan_id;
            $tarif->jenis_id=$value->jenis_id;
            $tarif->rekening_id=$value->rekening_id;
            $tarif->status=$value->status;
            $tarif->nilai=$value->nilai;
            $tarif->bukan_nilai=$value->bukan_nilai;
            $tarif->tipe=$value->tipe;
            $tarif->open=$value->open;
            $tarif->up=$value->up;
            $tarif->u_sarana=$value->sarana??0;
            $tarif->u_layanan=$value->layanan??0;
            $tarif->u_nilai=$value->nilai;
            $tarif->save();

            $idMapping[$value->id] = $tarif->id;
        }
        
        // **Loop kedua: Perbarui parent_id di UsulanTarif**
        foreach ($trf as $value) {
            if ($value->parent_id) {
                UsulanTarif::where('tarif_id', $value->id)->update([
                    'parent_id' => $idMapping[$value->parent_id] ?? 0
                ]);
            }
            }

            $usulan=UsulanTarif::where('pengajuan_id',$pengajuan->id)->get();
            return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }


function mutasiUsulan(Request $request)
{
    $trf = Tarif::where('ta_id', $request->ta_id)
    ->where('opd_id',$request->opd_id)
    ->where('uppd_id',$request->uppd_id)
    ->where('golongan_id',$request->golongan_id)
    ->where('jenis_id',$request->jenis_id)
    ->get();


$idMapping = [];

// Loop pertama: Proses data yang parent_id == 0 (header)
foreach ($trf->where('parent_id', 0) as $value) {
    $tarif = new UsulanTarif();
    $tarif->tarif_id       = $value->id;
    $tarif->grms_id        = $value->grms_id ?? 0;
    $tarif->ta_id          = $value->ta_id;
    $tarif->tu_id          = 1;
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
    $tarif->tu_id          = 1;
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

return back()->with('message',['type' => 'success', 'text' => 'Operation successful']);
}
}
