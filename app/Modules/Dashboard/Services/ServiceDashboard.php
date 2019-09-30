<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 27/02/19
 * Time: 08:04
 */

namespace App\Modules\Dashboard\Services;


use App\Modules\Accounts\Models\Accounts;
use App\Modules\Accounts\Models\AccountTransfers;
use App\Modules\Bills\Models\Bills;
use App\Modules\Calls\Models\Calls;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ServiceDashboard
{
    public function dashboard()
    {
        $dashboard = new Collection();
        $dashboard = $this->makeAccounts($dashboard);

        return $dashboard->all();
    }

    public function makeAccounts(Collection $dashboard)
    {
        $now = Carbon::now();

        $accounts = Accounts::all();
        $dataAccounts = [];

        foreach($accounts as $account) {
            $collection = new Collection();

            $calls = Calls::select(
                    DB::raw('(call_payments.amount - ROUND((call_payments.amount * call_payments.aliquot)/100, 2)) AS amount')
                )
                ->leftJoin('call_payments', 'calls.id', '=', 'call_payments.call_id')
                ->leftJoin('payment_methods', 'call_payments.payment_id', '=', 'payment_methods.id')
                ->where('calls.status', '=', 'P')
                ->where('payment_methods.account_id', '=', $account->id)
                ->where(function($query){
                    $query->whereNull('call_payments.date_in_account')
                        ->orWhere('call_payments.date_in_account', '<=', Carbon::now()->format('Y-m-d'));
                });

            $bills = Bills::select(
                    DB::raw('(bills.amount - ROUND((bills.amount * payment_methods.aliquot)/100, 2)) AS amount')
                )
                ->join('payment_methods', 'bills.payment_id', '=', 'payment_methods.id')
                ->whereIn('status', ['P', 'R'])
                ->where('type', '=', 'R')
                ->where('payment_methods.account_id', '=', $account->id);

            $accounts_in = $calls->unionAll($bills)->get()->sum('amount');

            $accounts_out = Bills::select('amount')
                ->join('payment_methods', 'bills.payment_id', '=', 'payment_methods.id')
                ->whereIn('status', ['P', 'R'])
                ->where('type', '<>', 'R')
                ->where('payment_methods.account_id', '=', $account->id)
                ->get()
                ->sum('amount');

            $transfer_in = AccountTransfers::select('amount')
                ->where('account_id', '=', $account->id)
                ->where('is_negative', '=', 0)
                ->get()
                ->sum('amount');

            $transfer_out = AccountTransfers::select('amount')
                ->where('account_id', '=', $account->id)
                ->where('is_negative', '=', 1)
                ->get()
                ->sum('amount');

            $accounts_in = $accounts_in + $transfer_in;
            $accounts_out = $accounts_out + $transfer_out;

            $total = $accounts_in - $accounts_out;

            $percentage_account_in = 50;
            $percentage_account_out = 50;

            if($total > 0) {
                $percentage_account_in = ($accounts_in > 0 ? ($accounts_in * 100) / abs($total) : 0);
                $percentage_account_out = ($accounts_out > 0 ? ($accounts_out * 100) / abs($total) : 0);
            }

            $collection->put('accounts_in', 'R$ ' . number_format($accounts_in, 2, ',', '.'));
            $collection->put('accounts_out', 'R$ ' . number_format($accounts_out, 2, ',', '.'));
            $collection->put('percentage_account_in', $percentage_account_in);
            $collection->put('percentage_account_out', $percentage_account_out);

            if ($total >= 0) {
                $collection->put('total_in_out', 'R$ ' . number_format($total, 2, ',', '.'));
                $collection->put('classTotal', 'text-success');
            } else {
                $collection->put('total_in_out', '- R$ ' . number_format(abs($total), 2, ',', '.'));
                $collection->put('classTotal', 'text-danger');
            }

            $collection->put('id', $account->id);

            $dataAccounts[$account->name] = $collection;

        }

        $dashboard->put("accounts", $dataAccounts);
        return $dashboard;
    }
}
