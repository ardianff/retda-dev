<?php

namespace App\Imports;

use App\Models\Npwpd;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NpwpdImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $existingRecord = Npwpd::where('nik',$row['nik'])->first();

    if ($existingRecord) {

        return null; // Return null because no new model is created
    }
    $npw = Npwpd::count();
    $count_npwpd = str_pad($npw + 1, 8, '0', STR_PAD_LEFT);
    $no_npwpd = '33' . '01' . 2024 . $count_npwpd;

    // Create a new record if id does not exist
    return new Npwpd([
        'nik' => $row['nik'],
        'tahun' => '2024',
    'no_npwpd' => $no_npwpd,
        'jenis' => 1,
        'nama_wp' => $row['nama'],
        'alamat' => $row['alamat'],
        'email' =>'',
        'no_telp' => '',
        'wa' => '',
        'kota_id' => 74,
        'status' => 'Active',
        'rekamdata' => 'Imported',
    ]);
    }
}
