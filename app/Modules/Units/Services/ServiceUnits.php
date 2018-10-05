<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 01/10/18
 * Time: 22:02
 */

namespace App\Modules\Units\Services;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\Units\Models\Units;
use Canducci\ZipCode\Facades\ZipCode;
use Illuminate\Support\Facades\DB as Capsule;

class ServiceUnits
{
    public function dataTable()
    {
        return DataTables::of(Units::query())
            ->addColumn('actions', function ($unity){
                return actionsUnits($unity);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function find($id)
    {
        return Units::find($id);
    }

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                if(Units::where('cnpj', '=', $request->input('cnpj'))->count() > 0)
                    throw new \Exception('Já existe uma unidade cadastrada com o CNPJ informado!');

                $cep = ZipCode::find($request->input('cep'))->getObject();
                $request->merge(['address' => $cep->logradouro]);
                $request->merge(['neighborhood' => $cep->bairro]);
                $request->merge(['city' => $cep->localidade]);
                $request->merge(['state' => $cep->uf]);

                $request->merge(['cnpj' => onlyNumber($request->input('cnpj'))]);
                $request->merge(['operating_hours' => json_encode($request->input('operating'))]);

                if (!Units::create($request->all()))
                    throw new \Exception('Não foi possível cadastrar uma nova unidade. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Unidade cadastrada com sucesso!',
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
                $unity = Units::find($request->input('id'));
                $unity->cnpj = $request->input('cnpj');
                $unity->social_name = $request->input('social_name');

                $cep = ZipCode::find($request->input('cep'))->getObject();
                $unity->cep = $request->input('cep');
                $unity->address = $cep->logradouro;
                $unity->number = $request->input('number');
                $unity->complement = $request->input('complement');
                $unity->neighborhood = $cep->bairro;
                $unity->city = $cep->localidade;
                $unity->state = $cep->uf;

                $unity->email = $request->input('email');
                $unity->phone = $request->input('phone');
                $unity->cell_phone = $request->input('cell_phone');
                $unity->operating_hours = json_encode($request->input('operating'));

                if (!$unity->save())
                    throw new \Exception('Não foi possível editar a unidade. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Unidade editada com sucesso!',
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
            $unit = Units::find($id);
            $unit->delete();

            return [
                'message' => 'Unidade deletada com sucesso!',
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