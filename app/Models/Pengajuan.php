<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function tu()
    {
        return $this->belongsTo(TahunUsulan::class, 'tu_id', 'id');
    }
    public function pengajuanOpd()
    {
        return $this->hasMany(PengajuanOpd::class, 'pengajuan_id', 'id');
    }
}
