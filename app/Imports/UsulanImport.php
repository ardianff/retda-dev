<?php

namespace App\Imports;

use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\UsulanTarif;
use App\Models\Satuan;


class UsulanImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // $map = []; // untuk menyimpan no_urut => id

        foreach ($rows as $index => $row) { // skip header
            $number = trim($row['number']);
            $uraian = $row['uraian'];
            $tipe = strtolower(trim($row['tipe']));


            $tarif = UsulanTarif::create([
                'id'     => $row['id'],
                'tarif_id'     => 0,
                'grms_id'     => 0,
                'ta_id'     => 1,
                'tu_id'     => 1,
                'tipe'        => $tipe,
                'number'     => $number,
                'uraian'      => $uraian,
                'satuan_id'   => $row['satuan_id'],
                'tarif_sarana' => 0,
                'tarif_layanan'=> 0,
                'nilai'        => 0,
                'parent_id'   => $row['parent_id'],
                'tahun'   => 2024,
                'opd_id'   => 36,
                'uppd_id'   => 248,
                'ujang_id'   => 248,
                'golongan_id'   => 1,
                'jenis_id'   => 16,
                'status'   => 1,
                'format_tarif'   => NULL,
                'rekening_id'   => $row['rekening_id']?? 0,
                'bkn_nilai'   => NULL,
                'u_format'   => $row['format_tarif'],
                'open'   => 0,
                'keterangan'   => NULL,
                'u_sarana'   => $row['tarif_sarana'],
                'u_layanan'   => $row['tarif_layanan'],
                'u_nilai'   => $row['nilai'],
            ]);

        }
    }
    
}
