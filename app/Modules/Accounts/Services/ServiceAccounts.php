<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 30/10/18
 * Time: 08:24
 */

namespace App\Modules\Accounts\Services;


use App\Modules\Accounts\Constants\AccountTypes;
use App\Modules\Accounts\Constants\Types;
use App\Modules\Accounts\Models\AccountTransfers;
use App\Modules\Calls\Models\Calls;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\Accounts\Models\Accounts;
use Illuminate\Support\Facades\DB as Capsule;

class ServiceAccounts
{
    private function formatRequest(Request $request)
    {
        if($request->input('type') == Types::INTERNAL) {
            $request->merge(['bank_id' => null]);
            $request->merge(['account_type' => null]);
            $request->merge(['agency_number' => null]);
            $request->merge(['account_number' => null]);
        }

        return $request;
    }

    public function dataTable()
    {
        return DataTables::of(Accounts::query())
            ->editColumn('type', function($account){
                return $account->type == Types::INTERNAL ? 'Interna' : 'Banco';
            })
            ->editColumn('bank_id', function($account){
                $bank = $account->bank();
                return  $bank ? $bank->name : '';
            })
            ->editColumn('account_type', function($account){
                if($account->type == Types::INTERNAL)
                    return '';

                return $account->account_type == AccountTypes::CHECKING_ACCOUNT ? 'Conta corrente' : 'Conta poupança';
            })
            ->addColumn('actions', function ($account){
                return actionsAccounts($account);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function find($id)
    {
        return Accounts::find($id);
    }

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $count = Accounts::where('name', '=', $request->input('name'))
                    ->count();

                if($count > 0)
                    throw new \Exception('Já existe uma conta cadastrada com este nome!');

                $request = $this->formatRequest($request);

                if (!Accounts::create($request->all()))
                    throw new \Exception('Não foi possível cadastrar uma nova conta. Por favor, tente mais tarde!');
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
                $account = Accounts::find($request->input('id'));
                $account->name = $request->input('name');
                $account->type = $request->input('type');
                $account->bank_id = $request->input('bank_id');
                $account->account_type = $request->input('account_type');
                $account->agency_number = $request->input('agency_number');
                $account->account_number = $request->input('account_number');

                if (!$account->save())
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
            $account = Accounts::find($id);
            $account->delete();

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

    public function transfer(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $amount = !empty($request->input('amount')) ? $request->input('amount') : 0;
                $amount = filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT) / 100;

                if($request->input('account_in') == $request->input('account_out'))
                    throw new \Exception('Conta de saída e entrada devem ser diferentes!');

                $in = Accounts::find($request->input('account_in'));
                $out = Accounts::find($request->input('account_out'));

                if($out->balance < $amount)
                    throw new \Exception('Saldo insuficiente para transferência (Saldo atual '.$out->balance.')');

                $in->balance = $in->balance + $amount;

                if(!$in->save())
                    throw new \Exception('Não foi possível fazer a transferência. Por favor, tente mais tarde!');

                $accountIn = new AccountTransfers();
                $accountIn->account_id = $request->input('account_in');
                $accountIn->is_negative = 0;
                $accountIn->amount = $amount;
                $accountIn->description = "Transferência da conta {$out->name}";

                if (!$accountIn->save())
                    throw new \Exception('Não foi possível fazer a transferência. Por favor, tente mais tarde!');

                $out->balance = $out->balance - $amount;

                if(!$out->save())
                    throw new \Exception('Não foi possível fazer a transferência. Por favor, tente mais tarde!');

                $accountOut = new AccountTransfers();
                $accountOut->account_id = $request->input('account_out');
                $accountOut->is_negative = 1;
                $accountOut->amount = $amount;
                $accountOut->description = "Transferência para a conta {$in->name}";

                if (!$accountOut->save())
                    throw new \Exception('Não foi possível fazer a transferência. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Transferência realizada com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }
}