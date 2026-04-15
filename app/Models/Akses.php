<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akses extends Model
{
    use HasFactory;

    protected $table = 'akses';
    protected $primaryKey = 'id';
    protected $guarded = [];

    // public function menu()
    // {
    //     return $this->belongsTo(Menu::class, 'menu_id', 'id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
