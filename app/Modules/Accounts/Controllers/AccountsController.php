<?php

namespace App\Modules\Accounts\Controllers;

use App\Modules\Accounts\Services\ServiceAccounts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class AccountsController extends Controller
{

    private $serviceAccounts;

    function __construct()
    {
        View::share('menu_active', 'accounts');
        View::share('menu_parent_active', 'financial');

        $this->serviceAccounts = new ServiceAccounts();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Accounts::index", dataTableAccounts());
    }

    public function dataTable()
    {
        return $this->serviceAccounts->dataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Accounts::create");
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
            'type' => 'required',
            'bank_id' => 'required_if:type,B',
            'account_type' => 'required_if:type,B',
            'agency_number' => 'required_if:type,B',
            'account_number' => 'required_if:type,B'
        ]);

        $return = $this->serviceAccounts->store($request);

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
        $account = $this->serviceAccounts->find($id);
        return view("Accounts::edit", ['account' => $account]);
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
            'type' => 'required',
            'bank_id' => 'required_if:type,B',
            'account_type' => 'required_if:type,B',
            'agency_number' => 'required_if:type,B',
            'account_number' => 'required_if:type,B'
        ]);

        $return = $this->serviceAccounts->update($request);

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
        $return = $this->serviceAccounts->destroy($id);
        return response()->json($return, 200);
    }
}
