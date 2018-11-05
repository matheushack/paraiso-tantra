<?php

namespace App\Modules\PaymentMethods\Controllers;

use App\Modules\PaymentMethods\Services\ServicePaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;

class PaymentMethodsController extends Controller
{
    private $servicePaymentMethods;

    function __construct()
    {
        View::share('menu_active', 'payments');
        View::share('menu_parent_active', 'financial');
        $this->servicePaymentMethods = new ServicePaymentMethods();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("PaymentMethods::index", dataTablePayments());
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTable()
    {
        return $this->servicePaymentMethods->dataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("PaymentMethods::create");
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
            'account_id' => 'required',
        ]);

        $return = $this->servicePaymentMethods->store($request);

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
        $payment = $this->servicePaymentMethods->find($id);
        return view("PaymentMethods::edit", ['payment' => $payment]);
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
            'account_id' => 'required',
        ]);

        $return = $this->servicePaymentMethods->update($request);

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
        $return = $this->servicePaymentMethods->destroy($id);
        return response()->json($return, 200);
    }
}
