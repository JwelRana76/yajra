<?php

namespace App\Service;

use App\Models\Employee;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;
use Yajra\DataTables\Facades\DataTables;

class EmployeeService extends Service {
    protected $model = Employee::class;

    public function forDataTable()
    {
        $employees = Employee::orderBy('id','desc')->get();
        $alldata = DataTables::of($employees)
        ->addColumn('action', function ($row) {
            $actionBtn = '<div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Action
            </button>
            <ul class="dropdown-menu">
                <li><a href="javascript:void(0)" class="dropdown-item editEmployee" data-toggle="tooltip" data-id="'.$row->id.'">Edit</a></li>
                <li><a href="javascript:void(0)" class="dropdown-item deleteEmployee" data-toggle="tooltip" data-id="'.$row->id.'">Delete</a></li>
            </div>';
            return $actionBtn;
        })
        ->make(true);
        return $alldata;
    }
}