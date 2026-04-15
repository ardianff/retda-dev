<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use App\Models\Importtarif; // Model untuk menyimpan data
use App\Models\TA; // Model untuk menyimpan data
use App\Models\Satuan; // Model untuk menyimpan data
use Illuminate\Support\Facades\DB;

class PdfImportController extends Controller
{
    public function import(Request $request)
    {
        $thn=TA::find($request->ta_id);
        $tahun = $thn->tahun;
        $ta_id = $thn->id;
        $opd_id = $request->opd_id;
        $uppd_id = $request->uppd_id;
        $golongan_id = $request->golongan_id;
        $jenis_id = $request->jenis_id;
        $rekening_id = $request->rekening_id;

        // Simpan file sementara
        $file = $request->file('file');
        $path = $file->store('pdfs');

        // Parsing PDF
        $parser = new Parser();
        $pdf = $parser->parseFile(storage_path('app/' . $path));
        $text = $pdf->getText(); // Ambil teks dari PDF

        // Pisahkan data berdasarkan baris
        $lines = explode("\n", trim($text));

        DB::beginTransaction();
        try {
            $parentMap = []; // Menyimpan ID berdasarkan kode unik

            foreach ($lines as $line) {
                // Gunakan regex untuk menangkap format data (kode, deskripsi, satuan, tarif, status)
                if (preg_match('/^(\d{2}(?:\.\d{2})*)\s+(.+?)\s+per\s+(\w+\/\w+)\s+([\d,]+)\s+(Aktif|Non-Aktif)/', $line, $matches)) {
                    $kode = trim($matches[1]);
                    $deskripsi = trim($matches[2]);
                    $satuan_nama = trim($matches[3]);
                    $tarif_retribusi = intval(str_replace(",", "", $matches[4]));
                    $status = $matches[5] == 'Aktif' ? 1 : 0;

                    // Tentukan parent berdasarkan struktur kode (misalnya: 01.02.01.01 → Parent adalah 01.02.01)
                    $parentKode = substr($kode, 0, strrpos($kode, '.')) ?: null;
                    $parent_id = $parentKode && isset($parentMap[$parentKode]) ? $parentMap[$parentKode] : 0;

                    $satuan = Satuan::where('uraian', $satuan_nama)->first();
                    $satuan_id = $satuan ? $satuan->id : 0;

                    // Simpan ke database
                    $tarif = Importtarif::create([
                        'parent_id' => $parent_id,
                        'number' => $kode,
                        'uraian' => $deskripsi,
                        'tipe' => $tarif_retribusi ? 'body' : 'header',
                        'satuan_id' =>  $satuan_id, // Bisa disesuaikan jika ada tabel satuan
                        'nama_satuan' => $satuan_nama,
                        'tarif_sarana' => 0, // Jika ada pembagian tarif, bisa dipisah
                        'tarif_layanan' => 0,
                        'nilai' => $tarif_retribusi,
                        'status' => $status,
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

                    // Simpan ID berdasarkan kode untuk referensi parent-child
                    $parentMap[$kode] = $tarif->id;
                }
            }

            DB::commit();
            return back()->with('success', 'Data berhasil diimpor!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

