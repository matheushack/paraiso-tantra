<?php

namespace App\Modules\Employees\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Modules\Employees\Services\ServiceEmployees;

class EmployeesController extends Controller
{
    private $serviceEmployees;

    function __construct()
    {
        View::share('menu_active', 'employees');
        View::share('menu_parent_active', 'units');

        $this->serviceEmployees = new ServiceEmployees();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Employees::index", dataTableEmployees());
    }

    public function dataTable()
    {
        return $this->serviceEmployees->dataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Employees::create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cpf' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'email' => 'required',
            'cell_phone' => 'required',
            'color' => 'required',
            'commission' => 'required'
        ]);

        $return = $this->serviceEmployees->store($request);

        return response()->json($return, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->serviceEmployees->find($id);
        return view("Employees::edit", ['employee' => $service]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cpf' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'email' => 'required',
            'cell_phone' => 'required',
            'color' => 'required',
            'commission' => 'required'
        ]);

        $return = $this->serviceEmployees->update($request);

        return response()->json($return, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $return = $this->serviceEmployees->destroy($id);
        return response()->json($return, 200);
    }
}
