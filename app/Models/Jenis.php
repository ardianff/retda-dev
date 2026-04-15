<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;

    protected $table = 'jenis';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id', 'id');
    }

    public function usulan()
    {
        return $this->hasMany(UsulanTarif::class, 'jenis_id', 'id');
    }
    public function tarif()
    {
        return $this->hasMany(Tarif::class, 'jenis_id', 'id');
    }
}
