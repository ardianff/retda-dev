<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importtarif extends Model
{
    use HasFactory;
    protected $table = 'importtarif';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id', 'id');
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Importtarif::class, 'parent_id');
    }

    // Relasi untuk children
    public function children()
    {
        return $this->hasMany(Importtarif::class, 'parent_id')->with('children'); // Recursive
    }
}
