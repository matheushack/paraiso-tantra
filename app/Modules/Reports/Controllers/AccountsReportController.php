<?php

namespace App\Modules\Reports\Controllers;

use App\Modules\Reports\Exports\AccountsExport;
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
        list($total, $report, $totalCalls, $totalRecipe, $totalExpense) = $this->serviceAccounts->filter($request);
        return view("Reports::accounts", [
            'total' => $total,
            'data' => $report,
            'totalCalls' => $totalCalls,
            'totalRecipe' => $totalRecipe,
            'totalExpense' => $totalExpense,
            'account_id' => $request->input('account_id')
        ]);
    }

    public function filter(Request $request)
    {
        list($total, $report, $totalCalls, $totalRecipe, $totalExpense) = $this->serviceAccounts->filter($request);

        return response()->json([
            'table' => utf8_encode(view("Reports::filters.accounts", [
                'data' => $report
            ])),
            'isPositive' => $total >= 0 ? true : false,
            'total' => 'R$ '.number_format($total, 2, ',', '.'),
            'totalCall' => 'R$ '.number_format($totalCalls, 2, ',', '.'),
            'totalRecipe' => 'R$ '.number_format($totalRecipe, 2, ',', '.'),
            'totalExpense' => 'R$ '.number_format($totalExpense, 2, ',', '.')
        ], 200);
    }

    public function excel(Request $request)
    {
        return $this->excel->download(new AccountsExport($request), 'contas.xlsx');
    }

    public function pdf(Request $request)
    {
        return $this->excel->download(new AccountsExport($request), 'contas.pdf');
    }
}
