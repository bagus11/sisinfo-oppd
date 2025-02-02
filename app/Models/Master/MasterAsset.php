<?php

namespace App\Models\Master;

use App\Models\Setting\InventoryCategory;
use App\Models\Setting\InventorySubCategory;
use App\Models\Setting\MasterCountry;
use App\Models\Setting\MasterSatgas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAsset extends Model
{
    use HasFactory;
    protected $guarded = [];
    function categoryRelation(){
        return $this->hasOne(InventoryCategory::class,'category_code','category');
    }
    function subCategoryRelation() {
        return $this->hasOne(InventorySubCategory::class,'subcategory_code','subcategory');
    }
}
