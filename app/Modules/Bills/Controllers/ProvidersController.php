<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 04/02/19
 * Time: 16:22
 */

namespace App\Modules\Bills\Controllers;


use App\Modules\Bills\Services\ServiceProviders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProvidersController
{
    private $serviceProviders;

    function __construct()
    {
        View::share('menu_active', 'providers');
        View::share('menu_parent_active', 'bills');

        $this->serviceProviders = new ServiceProviders();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Bills::providers.index", dataTableProviders());
    }

    public function dataTable()
    {
        return $this->serviceProviders->dataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Bills::providers.create");
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
            'phone' => 'required',
            'cell_phone' => 'required'
        ]);

        $return = $this->serviceProviders->store($request);

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
        $provider = $this->serviceProviders->find($id);
        return view("Bills::providers.edit", ['provider' => $provider]);
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
            'phone' => 'required',
            'cell_phone' => 'required'
        ]);

        $return = $this->serviceProviders->update($request);

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
        $return = $this->serviceProviders->destroy($id);
        return response()->json($return, 200);
    }

    public function search(Request $request)
    {
        $return = $this->serviceProviders->search($request);

        return response()->json($return, 200);
    }
}