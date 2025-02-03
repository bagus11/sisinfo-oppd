<?php
namespace App\Models\Master;

use App\Models\Setting\Inventory_type;
use App\Models\Setting\InventoryBrand;
use App\Models\Setting\InventoryCategory;
use App\Models\Setting\InventorySubCategory;
use App\Models\Setting\MasterSatgas;
use App\Models\Transaction\Asset\Inventaris;
use App\Models\Transaction\Asset\InventarisDetail;
use App\Models\Transaction\Asset\StatusDistribusiItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory;
    use SoftDeletes;
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
    function satgasRelation() {
        return $this->hasOne(MasterSatgas::class,'id','lokasi');
    }
    function detailInventarisRelation() {
        return $this->hasOne(InventarisDetail::class,'asset_code','asset_code');
    }
    function distribusiRelation() {
        return $this->hasOne(StatusDistribusiItem::class,'asset_code', 'asset_code');
    }
}
