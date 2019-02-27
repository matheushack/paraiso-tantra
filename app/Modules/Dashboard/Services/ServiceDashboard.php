<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 27/02/19
 * Time: 08:04
 */

namespace App\Modules\Dashboard\Services;


use App\Modules\Accounts\Models\Accounts;
use App\Modules\Bills\Models\Bills;
use App\Modules\Calls\Models\Calls;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ServiceDashboard
{
    public function dashboard()
    {
        $dashboard = new Collection();
        $dashboard = $this->makeMonthsYears($dashboard);
        $dashboard = $this->makeAccounts($dashboard);

        return $dashboard->all();
    }

    public function makeMonthsYears(Collection $dashboard)
    {
        $years = array_merge(range(Carbon::now()->year, Carbon::now()->subYears(10)->year), range(Carbon::now()->year, Carbon::now()->addYears(10)->year));
        sort($years);

        $dashboard->put('yearSelected', Carbon::now()->year);
        $dashboard->put('monthSelected', Carbon::now()->month);
        $dashboard->put('years', array_unique($years));
        $dashboard->put('months', [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ]);

        return $dashboard;
    }

    public function makeAccounts(Collection $dashboard)
    {
        $now = Carbon::now();

        $accounts = Accounts::all();
        $dataAccounts = [];

        foreach($accounts as $account) {
            $collection = new Collection();

            $calls = Calls::select('amount')
                ->where('status', '=', 'P')
                ->where('start', '>=', $now->startOfMonth()->format('Y-m-d H:i:s'))
                ->where('end', '<=', $now->endOfMonth()->format('Y-m-d H:i:s'));

            $bills = Bills::select('amount')
                ->whereIn('status', ['P', 'R'])
                ->where('type', '=', 'R')
                ->whereBetween('expiration_date', [$now->startOfMonth()->format('Y-m-d H:i:s'), $now->endOfMonth()->format('Y-m-d H:i:s')]);

            $accounts_in = $calls->union($bills)->get()->sum('amount');

            $accounts_out = Bills::select('amount')
                ->whereIn('status', ['P', 'R'])
                ->where('type', '<>', 'R')
                ->whereBetween('expiration_date', [$now->startOfMonth()->format('Y-m-d H:i:s'), $now->endOfMonth()->format('Y-m-d H:i:s')])
                ->get()
                ->sum('amount');

            $total = $accounts_in - $accounts_out;

            $percentage_account_in = ($accounts_in > 0 ? ($accounts_in * 100) / abs($total) : 0);
            $percentage_account_out = ($accounts_out > 0 ? ($accounts_out * 100) / abs($total) : 0);

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


            $dataAccounts[$account->name] = $collection;

        }

        $dashboard->put("accounts", $dataAccounts);

        return $dashboard;
    }
}