<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsulanTarif extends Model
{
    use HasFactory;

    protected $table = 'usulan_tarif';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id', 'id');
    }
    public function uppd()
    {
        return $this->belongsTo(Uppd::class, 'uppd_id', 'id');
    }
    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id', 'id');
    }
    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id', 'id');
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(UsulanTarif::class, 'parent_id');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id', 'id');
    }
    
    // Relasi untuk children
    public function children()
    {
        return $this->hasMany(UsulanTarif::class, 'parent_id')->with('children'); // Recursive
    }

    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'usulan_id', 'id'); // Recursive
    }
    
    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'tarif_id');
    }
    

}
