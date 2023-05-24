<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Service\EmployeeService;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Button;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->baseService = new EmployeeService;
    }

    // public function index(Request $request)
    // {

    //     if (request()->ajax()) {
    //         $this->baseService->forDataTable();
    //     }

    //     return view('employee');
    // }
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
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
        
        return view('employee');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Employee::updateOrCreate(['id'=>$request->employee_id],
            [
                'name' =>$request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ]
        );
        return response()->json(['success' => 'Employee Added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Employee::find($id)->delete();
        return response()->json(['success' => 'Employee deleted Success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Employee::find($id);
        return response()->json(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
    }

    public function view(Request $request)
    {
        $employee = Employee::all();
        return Datatables::of($employee)
        ->addColumn('action', function ($row) {
            $actionBtn = '<div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Action
            </button>
            <ul class="dropdown-menu">
                <li><button type="button" class="editEmployee btn text-danger" onclick="editme('.$row->id.')">Edit</button></li>
                <li><button type="button" class="deleteEmployee btn text-danger" onclick="deleteMe('.$row->id.')">Delete</button></li>
            </ul>
          </div>';
            return $actionBtn;
        })
        ->make(true);
    }
}
