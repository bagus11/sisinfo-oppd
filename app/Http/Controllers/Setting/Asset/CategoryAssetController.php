<?php

namespace App\Http\Controllers\Setting\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryAssetController extends Controller
{
    function index() {
        return view('setting.asset.category.category_asset-index');
    }
}
