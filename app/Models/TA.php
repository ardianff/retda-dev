<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TA extends Model
{
    use HasFactory;

    protected $table = 'tahun_anggaran';
    protected $primaryKey = 'id';
    protected $guarded = [];


}
