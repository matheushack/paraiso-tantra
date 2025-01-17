<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 20/11/18
 * Time: 08:07
 */

namespace App\Modules\Bills\Services;

use App\Modules\Accounts\Models\Accounts;
use App\Modules\Bills\Models\Bills;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB as Capsule;

class ServiceBills
{
    public function dataTable(Request $request)
    {
        $query = Bills::query()
            ->select('bills.*')
            ->join('providers', 'bills.provider_id', '=', 'providers.id');

        $dataTable = DataTables::of($query)
            ->editColumn('type', function($bill){
                return $bill->type == 'D' ? 'Despesa' : 'Receita';
            })
            ->editColumn('status', function($bill){
                switch ($bill->status){
                    case 'AP':
                        return 'Aguardando Pagamento';
                    case 'AR':
                        return 'Aguardando Recebimento';
                    case 'P':
                        return 'Pago';
                    case 'R':
                        return 'Recebido';
                }
            })
            ->editColumn('provider_id', function($bill){
                return $bill->provider->name;
            })
            ->editColumn('payment_id', function($bill){
                return $bill->payment->name;
            })
            ->editColumn('unity_id', function($bill){
                return $bill->unity->name;
            })
            ->editColumn('expiration_date', function($bill){
                return Carbon::parse($bill->expiration_date)->format('d/m/Y');
            })
            ->editColumn('amount', function($bill) use($request){
                if(empty($request->input('excelExport')))
                    return 'R$ '.number_format($bill->amount, 2, ',', '.');

                return $bill->amount;
            })
            ->addColumn('account', function($bill){
                return $bill->payment->account()->name;
            })
            ->addColumn('actions', function ($bill){
                return actionsBills($bill);
            })
            ->filter(function($query) use($request){
                $this->makeFilter($query, $request);
            })
            ->rawColumns(['actions', 'account'])
            ->make(true);

        $result = $dataTable->getData(true);
        $result['bills'] = $this->getTotalBills($request);

        return new JsonResponse($result);
    }

    private function makeFilter(Builder $query, Request $request)
    {
        $start = !empty($request->input('frm.start')) ? Carbon::createFromFormat('d/m/Y', $request->input('frm.start'))->startOfDay()->format('Y-m-d H:i:s') : '';
        $end = !empty($request->input('frm.end')) ? Carbon::createFromFormat('d/m/Y', $request->input('frm.end'))->endOfDay()->format('Y-m-d H:i:s') : '';

        if(!empty($start) && !empty($end))
            $query->whereBetween('bills.expiration_date', [$start, $end]);
        else if(!empty($start))
            $query->where('bills.expiration_date', '>=', $start);
        else if(!empty($end))
            $query->where('bills.expiration_date', '<=', $end);

        if(!empty($request->input('search.value'))) {
            $query->where('providers.name', 'like', '%' . $request->input('search.value') . '%');
        }

        return $query;
    }

    public function find($id)
    {
        return Bills::find($id);
    }

    private function getTotalBills(Request $request)
    {
        $types = ['R', 'D'];
        $return = [];

        for($i = 0; $i < count($types); $i++) {
            $query = Bills::query()
                ->select(
                    'bills.*'
                )
                ->join('providers', 'bills.provider_id', '=', 'providers.id');

            $start = !empty($request->input('frm.start')) ? Carbon::createFromFormat('d/m/Y', $request->input('frm.start'))->startOfDay()->format('Y-m-d H:i:s') : '';
            $end = !empty($request->input('frm.end')) ? Carbon::createFromFormat('d/m/Y', $request->input('frm.end'))->endOfDay()->format('Y-m-d H:i:s') : '';

            if (!empty($start) && !empty($end))
                $query->whereBetween('bills.expiration_date', [$start, $end]);
            else if (!empty($start))
                $query->where('bills.expiration_date', '>=', $start);
            else if (!empty($end))
                $query->where('bills.expiration_date', '<=', $end);

            if (!empty($request->input('search.value')))
                $query->where('providers.name', 'like', '%' . $request->input('search.value') . '%');

            $query->where('bills.type', '=', $types[$i]);

            $return[] = $query->get()
                ->sum('amount');
        }

        list($recipe, $expense) = $return;

        return [
            'total_in' => $recipe,
            'total_out' => $expense,
            'total' => $recipe - $expense,
            'total_in_formatted' => 'R$ '.number_format($recipe, 2, ',', '.'),
            'total_out_formatted' => 'R$ '.number_format($expense, 2, ',', '.'),
            'total_formatted' => 'R$ '.number_format(($recipe - $expense), 2, ',', '.')
        ];
    }

    private function formatRequest(Request $request, $update = false)
    {
        $request->merge(['expiration_date' => Carbon::createFromFormat('d/m/Y', $request->input('expiration_date'))->format('Y-m-d')]);

        if(!$update) {
            $payments = [];
            foreach ($request->input('payments') as $item) {
                $amount = !empty($item['amount']) ? $item['amount'] : 0;
                $payments[] = [
                    'id' => $item['payment_id'],
                    'amount' => filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT) / 100
                ];
            }

            $request->merge(['payments' => $payments]);

            return $request;
        }

        $amount = !empty($request->input('amount')) ? $request->input('amount') : 0;
        $request->merge(['amount' => filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT) / 100]);

        return $request;
    }

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $request = $this->formatRequest($request);

                foreach($request->input('payments') as $payment) {

                    if ($request->input('recurrent') == 'S') {
                        for ($i = 0; $i < (int)$request->input('months'); $i++) {
                            $expiration_date = Carbon::createFromFormat('Y-m-d', $request->input('expiration_date'))->addMonth($i)->format('Y-m-d');

                            foreach ($request->input('unity_id') as $unity_id) {
                                $bill = new Bills();
                                $bill->provider_id = $request->input('provider_id');
                                $bill->unity_id = $unity_id;
                                $bill->type = $request->input('type');
                                $bill->expiration_date = $expiration_date;
                                $bill->amount = $payment['amount'];
                                $bill->status = $i == 0 ? $request->input('status') : ($request->input('type') == 'R' ? 'AR' : 'AP');
                                $bill->payment_id = $payment['id'];
                                $bill->description = $request->input('description');

                                if(in_array($bill->status, ['R', 'P']))
                                    $bill->date_in_account = Carbon::now()->format('Y-m-d');

                                if (!$bill->save())
                                    throw new \Exception('Não foi possível cadastrar uma nova conta. Por favor, tente mais tarde!');

                                if(!empty($bill->date_in_account)) {
                                    $account = $bill->payment->account();

                                    if ($bill->type == 'R') {
                                        $account->balance = $account->balance + $bill->amount;
                                    } else {
                                        $account->balance = $account->balance - $bill->amount;
                                    }

                                    if (!$account->save())
                                        throw new \Exception('Houve um problema ao tentar atualziar o atendimento. Por favor, tente mais tarde!');
                                }
                            }
                        }
                    } else {
                        foreach ($request->input('unity_id') as $unity_id) {
                            $bill = new Bills();
                            $bill->provider_id = $request->input('provider_id');
                            $bill->unity_id = $unity_id;
                            $bill->type = $request->input('type');
                            $bill->expiration_date = $request->input('expiration_date');
                            $bill->amount = $payment['amount'];
                            $bill->status = $request->input('status');
                            $bill->payment_id = $payment['id'];
                            $bill->description = $request->input('description');

                            if(in_array($bill->status, ['R', 'P']))
                                $bill->date_in_account = Carbon::now()->format('Y-m-d');

                            if (!$bill->save())
                                throw new \Exception('Não foi possível cadastrar uma nova conta. Por favor, tente mais tarde!');

                            if(!empty($bill->date_in_account)) {
                                $account = $bill->payment->account();

                                if ($bill->type == 'R') {
                                    $account->balance = $account->balance + $bill->amount;
                                } else {
                                    $account->balance = $account->balance - $bill->amount;
                                }

                                if (!$account->save())
                                    throw new \Exception('Houve um problema ao tentar atualziar o atendimento. Por favor, tente mais tarde!');
                            }
                        }
                    }
                }
            });

            return [
                'message' => 'Conta cadastrada com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }

    public function update(Request $request)
    {
        try {
            Capsule::transaction(function () use ($request) {
                $request = $this->formatRequest($request, true);
                $bill = Bills::find($request->input('id'));
                $bill->provider_id = $request->input('provider_id');
                $bill->unity_id = $request->input('unity_id');
                $bill->type = $request->input('type');
                $bill->payment_id = $request->input('payment_id');
                $bill->status = $request->input('status');
                $bill->expiration_date = $request->input('expiration_date');
                $bill->amount = $request->input('amount');
                $bill->description = $request->input('description');

                $isUpdateBalanceAccount = false;

                if(in_array($bill->status, ['R', 'P']) && empty($bill->date_in_account)) {
                    $isUpdateBalanceAccount = true;
                    $bill->date_in_account = Carbon::now()->format('Y-m-d');
                }

                if (!$bill->save())
                    throw new \Exception('Não foi possível editar a conta. Por favor, tente mais tarde!');

                if($isUpdateBalanceAccount) {
                    $account = $bill->payment->account();

                    if ($bill->type == 'R') {
                        $account->balance = $account->balance + $bill->amount;
                    } else {
                        $account->balance = $account->balance - $bill->amount;
                    }

                    if (!$account->save())
                        throw new \Exception('Houve um problema ao tentar atualziar o atendimento. Por favor, tente mais tarde!');
                }
            });

            return [
                'message' => 'Conta editada com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }

    public function destroy($id)
    {
        try {
            $bill = Bills::find($id);

            if($bill->type == 'R'){
                $account = $bill->payment->account();
                $account->balance = $account->balance - $bill->amount;

                if(!$account->save())
                    throw new \Exception('Houve um problema ao tentar atualziar o atendimento. Por favor, tente mais tarde!');

            } else{
                $account = $bill->payment->account();
                $account->balance = $account->balance + $bill->amount;

                if(!$account->save())
                    throw new \Exception('Houve um problema ao tentar atualziar o atendimento. Por favor, tente mais tarde!');
            }

            $bill->delete();

            return [
                'message' => 'Conta deletada com sucesso!',
                'deleted' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'deleted' => false
            ];
        }
    }
}
