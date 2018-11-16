<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 16/09/18
 * Time: 21:07
 */

namespace App\Modules\PaymentMethods\Services;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\PaymentMethods\Models\PaymentMethods;
use Illuminate\Support\Facades\DB as Capsule;

class ServicePaymentMethods
{
    public function dataTable()
    {
        return DataTables::of(PaymentMethods::query())
            ->addColumn('actions', function ($payment){
                return actionsPayments($payment);
            })
            ->editColumn('account_id', function($payment){
                return $payment->account()->name;
            })
            ->editColumn('aliquot', function($payment){
                return $payment->aliquot > 0 ? number_format($payment->aliquot, 2, ',', '.').'%' : '0,00%';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return PaymentMethods::find($id);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            Capsule::transaction(function () use ($request) {
                if(PaymentMethods::where('name', '=', $request->input('name'))->count() > 0)
                    throw new \Exception('Já existe uma forma de pagamento cadastrada com esse nome!');

                $aliquot = !empty($request->input('aliquot')) ? $request->input('aliquot') : 0;
                $request->merge(['aliquot' => filter_var($aliquot, FILTER_SANITIZE_NUMBER_FLOAT) / 100]);

                if (!PaymentMethods::create($request->all()))
                    throw new \Exception('Não foi possível cadastrar uma nova forma de pagamento. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Forma de pagamento cadastrada com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function update(Request $request)
    {
        try {
            Capsule::transaction(function () use ($request) {
                $aliquot = !empty($request->input('aliquot')) ? $request->input('aliquot') : 0;
                $request->merge(['aliquot' => filter_var($aliquot, FILTER_SANITIZE_NUMBER_FLOAT) / 100]);

                $payment = PaymentMethods::find($request->input('id'));
                $payment->name = $request->input('name');
                $payment->account_id = $request->input('account_id');
                $payment->aliquot = $request->input('aliquot');

                if (!$payment->save())
                    throw new \Exception('Não foi possível editar a forma de pagamento. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Forma de pagamento editada com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            $payment = PaymentMethods::find($id);
            $payment->delete();

            return [
                'message' => 'Forma de pagamento deletada com sucesso!',
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