<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanOpd extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_opd';
    protected $primaryKey = 'id';
    protected $guarded = [];

   
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'id');
    }
}
