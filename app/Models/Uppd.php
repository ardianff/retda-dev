<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uppd extends Model
{
    use HasFactory;

    protected $table = 'uppd';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id', 'id');
    }
}
