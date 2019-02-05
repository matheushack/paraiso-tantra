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
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB as Capsule;

class ServiceBills
{
    public function dataTable()
    {
        return DataTables::of(Bills::query())
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
            ->addColumn('account', function($bill){
                return $bill->payment->account()->name;
            })
            ->addColumn('actions', function ($bill){
                return actionsBills($bill);
            })
            ->rawColumns(['actions', 'account'])
            ->make(true);
    }

    public function find($id)
    {
        return Bills::find($id);
    }

    private function formatRequest(Request $request)
    {
        $request->merge(['expiration_date' => Carbon::createFromFormat('d/m/Y', $request->input('expiration_date'))->format('Y-m-d')]);

        $amount = !empty($request->input('amount')) ? $request->input('amount') : 0;
        $request->merge(['amount' => filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT) / 100]);

        return $request;
    }

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $request = $this->formatRequest($request);

                if($request->input('recurrent') == 'S'){
                    for($i = 0; $i < (int) $request->input('months'); $i++){
                        $expiration_date = Carbon::createFromFormat('Y-m-d', $request->input('expiration_date'))->addMonth($i)->format('Y-m-d');

                        foreach($request->input('unity_id') as $unity_id) {
                            $bill = new Bills();
                            $bill->provider_id = $request->input('provider_id');
                            $bill->unity_id = $unity_id;
                            $bill->type = $request->input('type');
                            $bill->expiration_date = $expiration_date;
                            $bill->amount = $request->input('amount');
                            $bill->status = $request->input('status');
                            $bill->payment_id = $request->input('payment_id');
                            $bill->description = $request->input('description');

                            if (!$bill->save())
                                throw new \Exception('Não foi possível cadastrar uma nova conta. Por favor, tente mais tarde!');
                        }
                    }
                } else {
                    foreach ($request->input('unity_id') as $unity_id) {
                        $bill = new Bills();
                        $bill->provider_id = $request->input('provider_id');
                        $bill->unity_id = $unity_id;
                        $bill->type = $request->input('type');
                        $bill->expiration_date = $request->input('expiration_date');
                        $bill->amount = $request->input('amount');
                        $bill->status = $request->input('status');
                        $bill->payment_id = $request->input('payment_id');
                        $bill->description = $request->input('description');

                        if (!$bill->save())
                            throw new \Exception('Não foi possível cadastrar uma nova conta. Por favor, tente mais tarde!');
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
                $request = $this->formatRequest($request);
                $bill = Bills::find($request->input('id'));
                $bill->provider_id = $request->input('provider_id');
                $bill->unity_id = $request->input('unity_id');
                $bill->type = $request->input('type');
                $bill->payment_id = $request->input('payment_id');
                $bill->status = $request->input('status');
                $bill->expiration_date = $request->input('expiration_date');
                $bill->amount = $request->input('amount');
                $bill->description = $request->input('description');

                if (!$bill->save())
                    throw new \Exception('Não foi possível editar a conta. Por favor, tente mais tarde!');
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