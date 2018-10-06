<?php

namespace App\Modules\Rooms\Controllers;

use App\Modules\Rooms\Services\ServiceRooms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class RoomsController extends Controller
{
    private $serviceRooms;

    function __construct()
    {
        View::share('menu_active', 'rooms');
        View::share('menu_parent_active', 'units');

        $this->serviceRooms = new ServiceRooms();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Rooms::index", dataTableRooms());
    }

    public function dataTable()
    {
        return $this->serviceRooms->dataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Rooms::create");
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
            'unity_id' => 'required',
            'is_active' => 'required',
        ]);

        $return = $this->serviceRooms->store($request);

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
        $room = $this->serviceRooms->find($id);
        return view("Rooms::edit", ['room' => $room]);
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
            'unity_id' => 'required',
            'is_active' => 'required',
        ]);

        $return = $this->serviceRooms->update($request);

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
        $return = $this->serviceRooms->destroy($id);
        return response()->json($return, 200);
    }
}
