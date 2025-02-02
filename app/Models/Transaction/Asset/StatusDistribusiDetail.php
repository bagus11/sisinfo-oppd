<?php

namespace App\Models\Transaction\Asset;

use App\Models\Setting\MasterSatgas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusDistribusiDetail extends Model
{
    use HasFactory;
    protected $table = 'status_distribusi_detail';
    protected $guarded = [];

    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
    function locationRelation() {
        return $this->hasOne(MasterSatgas::class,'id', 'location');
    }
}
