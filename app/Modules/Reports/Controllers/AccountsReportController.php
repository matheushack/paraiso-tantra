<?php

namespace App\Modules\Reports\Controllers;

use App\Modules\Reports\Exports\CommissionsExport;
use App\Modules\Reports\Services\ServiceAccountsReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Excel;

class AccountsReportController extends Controller
{
    private $serviceAccounts;

    function __construct(Excel $excel)
    {
        View::share('menu_active', 'accounts');
        View::share('menu_parent_active', 'reports');

        $this->excel = $excel;
        $this->serviceAccounts = new ServiceAccountsReport();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->serviceAccounts->filter($request);
        return view("Reports::accounts", ['data' => $data, 'account_id' => $request->input('account_id')]);
    }

    public function filter(Request $request)
    {
        $report = $this->serviceAccounts->filter($request);

        return response()->json([
            'table' => utf8_encode(view("Reports::filters.accounts", ['data' => $report]))
        ], 200);
    }

    public function excel(Request $request)
    {
        return $this->excel->download(new CommissionsExport($request), 'contas.xlsx');
    }

    public function pdf(Request $request)
    {
        return $this->excel->download(new CommissionsExport($request), 'contas.pdf');
    }
}
