<?php

namespace App\Models\Transaction\Penerangan;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    use HasFactory;

    function reporterRelation() {
        return $this->hasOne(User::class, 'id','reporter');
    }
    function userRelation() {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
