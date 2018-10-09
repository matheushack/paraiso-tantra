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
        return view("Calls::index");
    }

    /**
     *
     */
    public function calendar()
    {
        $calendar = $this->serviceCalls->calendar();
        return response()->json($calendar, 200);
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
        $request->validate([
            'unity_id' => 'required',
            'service_id' => 'required',
            'employees' => 'required',
            'start' => 'required',
            'room_id' => 'required',
            'customer_id' => 'required',
        ]);

        $return = $this->serviceCalls->store($request);

        return response()->json($return, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function availability(Request $request)
    {
        $return = $this->serviceCalls->availability($request);

        return response()->json($return, 200);
    }
}
