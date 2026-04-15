<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunUsulan extends Model
{
    use HasFactory;

    protected $table = 'tahun_usulan';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function ta()
    {
        return $this->belongsTo(TA::class, 'ta_id', 'id');
    }
}
