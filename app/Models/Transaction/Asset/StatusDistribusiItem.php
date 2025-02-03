<?php

namespace App\Models\Transaction\Asset;

use App\Models\Master\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusDistribusiItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    function assetRelation(){
        return $this->hasOne(Asset::class, 'asset_code', 'asset_code');
    }
    function headRelation() {
        return $this->belongsTo(StatusDistribusi::class,'distribution_code','distribution_code');
    }
    
}
