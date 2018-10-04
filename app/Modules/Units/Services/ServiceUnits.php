<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 01/10/18
 * Time: 22:02
 */

namespace App\Modules\Units\Services;

use Yajra\DataTables\DataTables;
use App\Modules\Units\Models\Units;
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

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function () use ($request) {
                if(Units::where('cnpj', '=', $request->input('cnpj'))->count() > 0)
                    throw new \Exception('Já existe uma unidade cadastrada com o CNPJ informado!');

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
}