<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Company;
use App\Models\Setting\CompanyLevel;
use App\Models\Setting\CompanyType;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    function index() {
        return view('setting.company.company-index');
    }
    function getCompany() {
        $data = Company::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getCompanyLevel() {
        $data = CompanyLevel::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getCompanyType() {
        $data = CompanyType::all();
        return response()->json([
            'data'=>$data,
        ]);
    }

}
