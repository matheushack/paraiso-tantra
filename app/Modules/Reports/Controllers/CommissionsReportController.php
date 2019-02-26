<?php

namespace App\Modules\Reports\Controllers;

use App\Modules\Reports\Exports\CommissionsExport;
use App\Modules\Reports\Services\ServiceCommissionsReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Excel;

class CommissionsReportController extends Controller
{
    private $serviceCommissions;

    function __construct(Excel $excel)
    {
        View::share('menu_active', 'commissions');
        View::share('menu_parent_active', 'reports');

        $this->excel = $excel;
        $this->serviceCommissions = new ServiceCommissionsReport();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->serviceCommissions->filter($request);
        return view("Reports::commissions", ['data' => $data]);
    }

    public function filter(Request $request)
    {
        $report = $this->serviceCommissions->filter($request);

        return response()->json([
            'table' => utf8_encode(view("Reports::filters.commissions", ['data' => $report]))
        ], 200);
    }

    public function excel()
    {
        return $this->excel->download(new CommissionsExport(), 'comissoes.xlsx');
    }

    public function pdf()
    {
        return $this->excel->download(new CommissionsExport(), 'comissoes.pdf');
    }
}
