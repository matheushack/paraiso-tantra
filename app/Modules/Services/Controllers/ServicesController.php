<?php

namespace App\Modules\Services\Controllers;

use App\Modules\Services\Services\ServiceServicing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class ServicesController extends Controller
{
    private $serviceServicing;

    function __construct()
    {
        View::share('menu_active', 'services');
        View::share('menu_parent_active', 'units');

        $this->serviceServicing = new ServiceServicing();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Services::index", dataTableServices());
    }

    public function dataTable()
    {
        return $this->serviceServicing->dataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Services::create");
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
            'amount' => 'required',
            'duration' => 'required',
            'is_active' => 'required',
        ]);

        $return = $this->serviceServicing->store($request);

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
        $service = $this->serviceServicing->find($id);
        return view("Services::edit", ['service' => $service]);
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
            'amount' => 'required',
            'duration' => 'required',
            'is_active' => 'required',
        ]);

        $return = $this->serviceServicing->update($request);

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
        $return = $this->serviceServicing->destroy($id);
        return response()->json($return, 200);
    }
}
