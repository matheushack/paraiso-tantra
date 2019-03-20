<?php

namespace App\Modules\Reports\Controllers;

use App\Modules\Reports\Exports\CustomersExport;
use App\Modules\Reports\Services\ServiceCustomersReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Excel;

class CustomersReportController extends Controller
{
    private $serviceCustomers;

    function __construct(Excel $excel)
    {
        View::share('menu_active', 'customers');
        View::share('menu_parent_active', 'reports');

        $this->excel = $excel;
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

    public function excel(Request $request)
    {
        return $this->excel->download(new CustomersExport($request), 'clientes.xlsx');
    }

    public function pdf(Request $request)
    {
        return $this->excel->download(new CustomersExport($request), 'clientes.pdf');
    }
}
