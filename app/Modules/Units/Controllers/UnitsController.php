<?php

namespace App\Modules\Units\Controllers;

use App\Modules\Units\Services\ServiceUnits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class UnitsController extends Controller
{
    private $serviceUnits;

    function __construct()
    {
        View::share('menu_active', 'manage-units');
        View::share('menu_parent_active', 'units');

        $this->serviceUnits = new ServiceUnits();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Units::index", dataTableUnits());
    }

    public function dataTable()
    {
        return $this->serviceUnits->dataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Units::create");
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
            'cnpj' => 'required',
            'name' => 'required',
            'social_name' => 'required',
            'cep' => 'required',
            'number' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cell_phone' => 'required'
        ]);

        $return = $this->serviceUnits->store($request);

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
        $unity = $this->serviceUnits->find($id);
        return view("Units::edit", ['unity' => $unity, 'operating_hours' => json_decode($unity->operating_hours)]);
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
            'cnpj' => 'required',
            'name' => 'required',
            'social_name' => 'required',
            'cep' => 'required',
            'number' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cell_phone' => 'required'
        ]);

        $return = $this->serviceUnits->update($request);

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
        $return = $this->serviceUnits->destroy($id);
        return response()->json($return, 200);
    }
}
