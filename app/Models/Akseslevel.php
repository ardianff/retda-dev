<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akseslevel extends Model
{
    use HasFactory;

    protected $table = 'akseslevel';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
