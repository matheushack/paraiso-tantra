<?php

namespace App\Modules\Reports\Controllers;

use App\Modules\Reports\Exports\ExtractExport;
use App\Modules\Reports\Services\ServiceExtractReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Excel;

class ExtractReportController extends Controller
{
    private $serviceExtract;

    function __construct(Excel $excel)
    {
        View::share('menu_active', 'extract');
        View::share('menu_parent_active', 'reports');

        $this->excel = $excel;
        $this->serviceExtract = new ServiceExtractReport();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->serviceExtract->filter($request);
        return view("Reports::extract", ['extract' => $data]);
    }

    public function filter(Request $request)
    {
        $report = $this->serviceExtract->filter($request);

        return response()->json([
            'table' => utf8_encode(view("Reports::filters.extract", ['extract' => $report]))
        ], 200);
    }

    public function excel(Request $request)
    {
        return $this->excel->download(new ExtractExport($request), 'extrato.xlsx');
    }

    public function pdf(Request $request)
    {
        return $this->excel->download(new ExtractExport($request), 'extrato.pdf');
    }
}
