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
        $map = []; // untuk menyimpan no_urut => id

        foreach ($rows->skip(1) as $index => $row) { // skip header
            $no_urut = trim($row[0]);
            $uraian = $row[1];
            $tipe = strtolower(trim($row[6]));

            // Cari parent berdasarkan pola no_urut
            $parent_no_urut = null;
            if (substr_count($no_urut, '.') === 2) {
                // level 3 (contoh: 01.01.001) → parent: 01.01
                $parent_no_urut = implode('.', array_slice(explode('.', $no_urut), 0, 2));
            } elseif (substr_count($no_urut, '.') === 1) {
                // level 2 (contoh: 01.01) → parent: 01
                $parent_no_urut = explode('.', $no_urut)[0];
            } else {
                // root
                $parent_no_urut = null;
            }

            $tarif = Tarif::create([
                'no_urut'     => $no_urut,
                'uraian'      => $uraian,
                'satuan'      => $row[2],
                'jasa_sarana' => $row[3],
                'jasa_layanan'=> $row[4],
                'jumlah_tarif'=> $row[5],
                'tipe'        => $tipe,
                'parent_id'   => $parent_no_urut && isset($map[$parent_no_urut]) ? $map[$parent_no_urut] : null,
            ]);

            $map[$no_urut] = $tarif->id; // simpan id untuk referensi parent selanjutnya
        }
    }
    
}
