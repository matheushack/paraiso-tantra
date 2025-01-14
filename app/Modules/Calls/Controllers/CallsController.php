<?php

namespace App\Modules\Calls\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Modules\Calls\Services\ServiceCalls;

/**
 * Class CallsController
 * @package App\Modules\Calls\Controllers
 */
class CallsController extends Controller
{

    /**
     * @var ServiceCalls
     */
    private $serviceCalls;

    /**
     * CallsController constructor.
     */
    function __construct()
    {
        View::share('menu_active', 'calls');
        $this->serviceCalls = new ServiceCalls();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Calls::index", ['unity_id' => 1]);
    }

    /**
     *
     */
    public function calendar(Request $request)
    {
        $calendar = $this->serviceCalls->calendar($request);
        return response()->json($calendar, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view("Calls::create", ['unity_id' => $request->input('unity_id')]);
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
            'unity_id' => 'required',
            'service_id' => 'required',
            'employees' => 'required',
            'start' => 'required',
            'room_id' => 'required',
            'customer_id' => 'required',
            'first_call' => 'required',
        ]);

        $return = $this->serviceCalls->store($request);

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
        $call = $this->serviceCalls->find($id);

        $call->employees()->get()->each(function($item) use(&$employees){
            $employees[] = $item->employee_id;
        });

        $call->payments()->get()->each(function($item) use(&$payments){
            $payments[] = [
                'payment_id' => $item->payment_id,
                'amount' => $item->amount
            ];
        });

        return view("Calls::edit", ['call' => $call, 'employees' => implode(',',$employees), 'payments' => $payments]);
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
            'unity_id' => 'required',
            'service_id' => 'required',
            'employees' => 'required',
            'start' => 'required',
            'room_id' => 'required',
            'customer_id' => 'required',
            'first_call' => 'required',
        ]);

        $return = $this->serviceCalls->update($request);

        return response()->json($return, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateFinancial(Request $request)
    {
        $request->validate([
            'call_id' => 'required',
            'status' => 'required',
            'type_discount' => 'required_with:discount',
            'payments' => 'required'
        ]);

        $return = $this->serviceCalls->updateFinancial($request);

        return response()->json($return, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePayment(Request $request)
    {
        $request->validate([
            'call_id' => 'required',
            'payments' => 'required'
        ]);

        $return = $this->serviceCalls->updatePayment($request);

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
        $return = $this->serviceCalls->destroy($id);
        return response()->json($return, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function availability(Request $request)
    {
        $return = $this->serviceCalls->availability($request);
        return response()->json($return, 200);
    }
}
