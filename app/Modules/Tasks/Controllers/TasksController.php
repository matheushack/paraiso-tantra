<?php

namespace App\Modules\Tasks\Controllers;

use App\Modules\Tasks\Services\ServiceTasks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class TasksController extends Controller
{
    private $serviceTasks;

    function __construct()
    {
        View::share('menu_active', 'task');
        View::share('menu_parent_active', 'system');
        $this->serviceTasks = new ServiceTasks();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->serviceTasks->list();
        return view("Tasks::index", ['tasks' => $tasks]);
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
            'job.*.command' => 'required',
            'job.*.schedule' => 'required'
        ]);

        $return = $this->serviceTasks->store($request);

        return response()->json($return, 200);
    }

    public function database()
    {
        $return = $this->serviceTasks->database();
        return response()->json($return, 200);
    }
}
