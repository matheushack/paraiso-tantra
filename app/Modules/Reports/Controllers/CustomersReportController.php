<?php

namespace App\Modules\Reports\Controllers;

use App\Modules\Reports\Services\ServiceCustomersReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CustomersReportController extends Controller
{
    private $serviceCustomers;

    function __construct()
    {
        View::share('menu_active', 'customers');
        View::share('menu_parent_active', 'reports');

        $this->serviceCustomers = new ServiceCustomersReport();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->serviceCustomers->filter($request);
        return view("Reports::customers", ['data' => $data]);
    }

    public function filter(Request $request)
    {
        $report = $this->serviceCustomers->filter($request);

        return response()->json([
            'table' => utf8_encode(view("Reports::filters.customers", ['data' => $report]))
        ], 200);
    }
}
