<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 06/10/18
 * Time: 20:04
 */

namespace App\Modules\Employees\Services;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\Employees\Models\Employees;
use Illuminate\Support\Facades\DB as Capsule;

class ServiceEmployees
{
    public function dataTable()
    {
        return DataTables::of(Employees::query())
            ->editColumn('is_active', function($employee){
                return $employee->is_active ? 'Sim' : 'Não';
            })
            ->addColumn('actions', function ($employee){
                return actionsEmployees($employee);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function find($id)
    {
        return Employees::find($id);
    }

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $count = Employees::where('name', '=', $request->input('name'))
                    ->count();

                if($count > 0)
                    throw new \Exception('Já existe um serviço cadastrado com este nome!');

                if (!Employees::create($request->all()))
                    throw new \Exception('Não foi possível cadastrar um novo serviço. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Serviço cadastrado com sucesso!',
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

                $employee = Employees::find($request->input('id'));
                $service->name = $request->input('name');
                $service->is_active = $request->input('is_active');
                $service->description = $request->input('description');
                $service->amount = $request->input('amount');
                $service->discount = $request->input('discount');
                $service->duration = $request->input('duration');

                if (!$employee->save())
                    throw new \Exception('Não foi possível editar o serviço. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Serviço editado com sucesso!',
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
            $employee = Employees::find($id);
            $employee->delete();

            return [
                'message' => 'Funcionário deletado com sucesso!',
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