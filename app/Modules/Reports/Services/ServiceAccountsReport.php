<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 05/02/19
 * Time: 15:13
 */

namespace App\Modules\Reports\Services;


use App\Modules\Bills\Models\Bills;
use App\Modules\Calls\Models\Calls;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceAccountsReport
{
    private function formatRequest(Request $request)
    {
        if(!empty($request->input('start'))) {
            $start = Carbon::createFromFormat('d/m/Y', $request->input('start'))->startOfDay();
            $request->merge(['start' => $start->format('Y-m-d H:i:s')]);
        }

        if(!empty($request->input('end'))) {
            $end = Carbon::createFromFormat('d/m/Y', $request->input('end'))->endOfDay();
            $request->merge(['end' => $end->format('Y-m-d H:i:s')]);
        }

        return $request;
    }

    public function filter(Request $request)
    {
        $request = $this->formatRequest($request);

        $calls = Calls::select(
                DB::raw("accounts.name as account"),
                DB::raw("services.name as description"),
                DB::raw("units.name as unity"),
                DB::raw("'A' as type"),
                DB::raw("calls.start as date"),
                DB::raw("(calls.amount - ROUND((calls.amount * calls.aliquot)/100, 2)) AS amount")
            )
            ->join('payment_methods', 'calls.payment_id', '=', 'payment_methods.id')
            ->join('accounts', 'payment_methods.account_id', '=', 'accounts.id')
            ->join('units', 'calls.unity_id', '=', 'units.id')
            ->join('services', 'calls.service_id', '=', 'services.id')
            ->where('calls.status', '=', 'P');

        $bills = Bills::select(
                DB::raw("accounts.name as account"),
                DB::raw("providers.name as description"),
                DB::raw("units.name as unity"),
                DB::raw("bills.type"),
                DB::raw("bills.expiration_date as date"),
                DB::raw("IF(bills.type = 'R', (bills.amount - ROUND((bills.amount * payment_methods.aliquot)/100, 2)), bills.amount) AS amount")
            )
            ->join('payment_methods', 'bills.payment_id', '=', 'payment_methods.id')
            ->join('accounts', 'payment_methods.account_id', '=', 'accounts.id')
            ->join('units', 'bills.unity_id', '=', 'units.id')
            ->join('providers', 'bills.provider_id', '=', 'providers.id')
            ->whereIn('bills.status', ['P', 'R']);

        if($request->input('account_id')) {
            $calls->where('accounts.id', '=', $request->input('account_id'));
            $bills->where('accounts.id', '=', $request->input('account_id'));
        }

        if(!empty($request->input('start')) && !empty($request->input('end'))){
            $calls->where('calls.start', '>=', $request->input('start'))
                ->where('calls.end', '<=', $request->input('end'));
            $bills->whereBetween('bills.expiration_date', [$request->input('start'), $request->input('end')]);
        }else if(!empty($request->input('start'))){
            $calls->where('calls.start', '>=', $request->input('start'));
            $bills->where('bills.expiration_date', '>=', $request->input('start'));
        }else if(!empty($request->input('end'))){
            $calls->where('calls.end', '<=', $request->input('end'));
            $bills->where('bills.expiration_date', '<=', $request->input('end'));
        }

        $report = $calls->unionAll($bills)
            ->orderBy('date')
            ->get();

        $totalCalls = 0;
        $totalRecipe = 0;
        $totalExpense = 0;

        $report->each(function($item, $key) use(&$totalRecipe, &$totalExpense, &$totalCalls){
            switch ($item->type){
                case 'A':
                    $totalCalls = $totalCalls + floatval($item->amount);
                    break;
                case 'R':
                    $totalRecipe = $totalRecipe + floatval($item->amount);
                    break;
                case 'D':
                    $totalExpense = $totalExpense + floatval($item->amount);
                    break;
            }
        });

        $total = ($totalRecipe + $totalCalls) - $totalExpense;

        return [
            $total,
            $report,
            $totalCalls,
            $totalRecipe,
            $totalExpense
        ];
    }
}