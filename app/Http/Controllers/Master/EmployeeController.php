<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    function index() {
        return view('master.employee.employee-index');
    }
    function getEmployee() {
        $data = Employee::with([
            'userRelation'
        ])->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
}
