<?php

namespace App\Modules\Bills\Controllers;

use App\Modules\Bills\Services\ServiceBills;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class BillsController extends Controller
{
    private $serviceBills;

    function __construct()
    {
        View::share('menu_active', 'manage-bills');
        View::share('menu_parent_active', 'bills');

        $this->serviceBills = new ServiceBills();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Bills::index", dataTableBills());
    }

    public function dataTable(Request $request)
    {
        return $this->serviceBills->dataTable($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Bills::create");
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
            'provider_id' => 'required',
            'unity_id' => 'required',
            'payments' => 'required',
            'type' => 'required',
            'expiration_date' => 'required',
            'status' => 'required',
            'recurrent' => 'required',
            'months' => 'required_if:recurrent,S'
        ]);

        $return = $this->serviceBills->store($request);

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
        $bill = $this->serviceBills->find($id);
        return view("Bills::edit", ['bill' => $bill]);
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
            'provider_id' => 'required',
            'unity_id' => 'required',
            'payment_id' => 'required',
            'type' => 'required',
            'expiration_date' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);

        $return = $this->serviceBills->update($request);

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
        $return = $this->serviceBills->destroy($id);
        return response()->json($return, 200);
    }
}
