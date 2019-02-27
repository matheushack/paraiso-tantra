<?php

namespace App\Modules\Dashboard\Controllers;

use App\Modules\Dashboard\Services\ServiceDashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    private $serviceDashboard;

    function __construct()
    {
        View::share('menu_active', 'dashboard');
        $this->serviceDashboard = new ServiceDashboard();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dashboard = $this->serviceDashboard->dashboard();
        return view("Dashboard::index", ['dashboard' => $dashboard]);
    }
}
