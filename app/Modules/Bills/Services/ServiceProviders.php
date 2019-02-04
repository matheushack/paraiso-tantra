<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 04/02/19
 * Time: 16:23
 */

namespace App\Modules\Bills\Services;


use App\Modules\Bills\Models\Providers;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServiceProviders
{
    public function dataTable()
    {
        return DataTables::of(Providers::query())
            ->addColumn('actions', function ($provider){
                return actionsProviders($provider);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function find($id)
    {
        return Providers::find($id);
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
            if (!Providers::create($request->all()))
                throw new \Exception('Não foi possível cadastrar um novo fornecedor. Por favor, tente mais tarde!');

            return [
                'message' => 'Fornecedor cadastrado com sucesso!',
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
            $provider = Providers::find($request->input('id'));
            $provider->name = $request->input('name');
            $provider->phone = $request->input('phone');
            $provider->cell_phone = $request->input('cell_phone');

            if (!$provider->save())
                throw new \Exception('Não foi possível editar o fornecedor. Por favor, tente mais tarde!');

            return [
                'message' => 'Fornecedor editado com sucesso!',
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
            $bill = Providers::find($id);
            $bill->delete();

            return [
                'message' => 'Fornecedor deletado com sucesso!',
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