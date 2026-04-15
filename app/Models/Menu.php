<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'id';
    protected $guarded = [];


    // public function akses()
    // {
    //     return $this->hasMany(Akses::class, 'menu_id', 'id');
    // }
    public function childrenRecursive()
    {
        return $this->hasMany(Menu::class, 'parent_id')->with('childrenRecursive');
    }

    public function children()
{
    return $this->hasMany(Menu::class, 'parent_id')->with('children');
}
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }
}
