<?php

namespace App\Imports;
use App\Models\UsulanTarif;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TarifImport implements OnEachRow, WithHeadingRow
{
    protected $grms_id;
    protected $idCounter = 1;
    protected $parentStack = [];

    public function __construct()
    {
        $this->grms_id = (UsulanTarif::max('grms_id') ?? 0) + 1;
        $this->idCounter = (Tarif::max('id') ?? 0) + 1;
    }

    public function onRow(Row $row)
    {
        $data = $row->toArray();

        if (!isset($data['no_urut']) || !isset($data['uraian'])) {
            return;
        }

        $no_urut = trim($data['no_urut']);
        $depth = substr_count($no_urut, '.');
        $parent_id = $depth > 0 ? ($this->parentStack[$depth - 1] ?? null) : null;

        $tarif = new Tarif();
        $tarif->id = $this->idCounter++;
        $tarif->parent_id = $parent_id;
        $tarif->number = $no_urut;
        $tarif->uraian = $data['uraian'];
        $tarif->satuan = $data['satuan'] ?? null;
        $tarif->jasa_sarana = $this->parseNumber($data['jasa_sarana'] ?? null);
        $tarif->jasa_layanan = $this->parseNumber($data['jasa_layanan'] ?? null);
        $tarif->jumlah_tarif = $this->parseNumber($data['jumlah_tarif'] ?? null);
        $tarif->grms_id = $this->grms_id;
        $tarif->save();

        // Update stack untuk hierarchy
        $this->parentStack[$depth] = $tarif->id;
        $this->parentStack = array_slice($this->parentStack, 0, $depth + 1);
    }

    private function parseNumber($value)
    {
        return $value ? (int) str_replace([',', '.'], '', $value) : null;
    }
}


