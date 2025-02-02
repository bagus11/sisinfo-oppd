<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    function menusRelation() {
        return $this->hasOne(Menu::class,'id', 'menus_id');
    }
}
