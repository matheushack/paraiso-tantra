<?php

namespace App\Modules\Users\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Modules\Users\Services\ServiceUsers;

/**
 * Class UsersController
 * @package App\Modules\Users\Controllers
 */
class UsersController extends Controller
{
    /**
     * @var ServiceUsers
     */
    private $serviceUsers;

    /**
     * UsersController constructor.
     */
    function __construct()
    {
        View::share('menu_active', 'users');
        View::share('menu_parent_active', 'system');
        $this->serviceUsers = new ServiceUsers();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Users::index", dataTableUsers());
    }

    /**
     * @return mixed
     */
    public function dataTable()
    {
        return $this->serviceUsers->dataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Users::create");
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
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $return = $this->serviceUsers->store($request);

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
        $user = $this->serviceUsers->find($id);
        return view("Users::edit", ['user' => $user]);
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
            'name' => 'required'
        ]);

        $return = $this->serviceUsers->update($request);

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
        $return = $this->serviceUsers->destroy($id);
        return response()->json($return, 200);
    }
}
