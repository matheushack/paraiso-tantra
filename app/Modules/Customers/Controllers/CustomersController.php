<?php

namespace App\Modules\Customers\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Modules\Customers\Services\ServiceCustomers;

class CustomersController extends Controller
{

    private $serviceCustomers;

    function __construct()
    {
        View::share('menu_active', 'customers');

        $this->serviceCustomers = new ServiceCustomers();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Customers::index", dataTableCustomers());
    }

    public function dataTable()
    {
        return $this->serviceCustomers->dataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Customers::create");
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
            'gender' => 'required'
        ]);

        $return = $this->serviceCustomers->store($request);

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
        $service = $this->serviceCustomers->find($id);
        return view("Customers::edit", ['customer' => $service]);
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
            'gender' => 'required'
        ]);

        $return = $this->serviceCustomers->update($request);

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
        $return = $this->serviceCustomers->destroy($id);
        return response()->json($return, 200);
    }

    public function search(Request $request)
    {
        $return = $this->serviceCustomers->search($request);

        return response()->json($return, 200);
    }
}
