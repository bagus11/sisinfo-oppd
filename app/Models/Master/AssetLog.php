<?php

namespace App\Models\Master;

use App\Models\Setting\Inventory_type;
use App\Models\Setting\InventoryBrand;
use App\Models\Setting\InventoryCategory;
use App\Models\Setting\InventorySubCategory;
use App\Models\Setting\MasterSatgas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AssetLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    function categoryRelation() {
        return $this->hasOne(InventoryCategory::class, 'id', 'kategori');
    }

    function subCategoryRelation() {
        return $this->hasOne(InventorySubCategory::class, 'id', 'subkategori');
    }

    function typeRelation() {
        return $this->hasOne(Inventory_type::class, 'id', 'jenis');
    }

    function merkRelation() {
        return $this->hasOne(InventoryBrand::class, 'id', 'merk');
    }
    function picRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
    function satgasRelation() {
        return $this->hasOne(MasterSatgas::class, 'id', 'lokasi');
    }
}
