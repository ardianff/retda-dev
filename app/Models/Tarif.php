<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tarif';
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
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
    }
    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Tarif::class, 'parent_id');
    }

    // Relasi untuk children
    public function children()
    {
        return $this->hasMany(Tarif::class, 'parent_id')->with('children'); // Recursive
    }
}
