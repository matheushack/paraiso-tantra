<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 07/02/19
 * Time: 11:50
 */

namespace App\Modules\Reports\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Reports\Exports\CallsExport;
use App\Modules\Reports\Services\ServiceCallsReport;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class CallsReportController extends Controller
{
    private $serviceCalls;

    function __construct(Excel $excel)
    {
        View::share('menu_active', 'calls');
        View::share('menu_parent_active', 'reports');

        $this->excel = $excel;
        $this->serviceCalls = new ServiceCallsReport();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->serviceCalls->filter($request);
        return view("Reports::calls", ['data' => $data]);
    }

    public function filter(Request $request)
    {
        $report = $this->serviceCalls->filter($request);

        return response()->json([
            'table' => utf8_encode(view("Reports::filters.calls", ['data' => $report]))
        ], 200);
    }

    public function excel(Request $request)
    {
        return $this->excel->download(new CallsExport($request), 'atendimentos.xlsx');
    }

    public function pdf(Request $request)
    {
        return $this->excel->download(new CallsExport($request), 'atendimentos.pdf');
    }
}