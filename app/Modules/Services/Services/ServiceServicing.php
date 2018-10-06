<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 06/10/18
 * Time: 17:10
 */

namespace App\Modules\Services\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\Services\Models\Services;
use Illuminate\Support\Facades\DB as Capsule;

class ServiceServicing
{
    private function formatRequest(Request $request)
    {
        $duration = Carbon::createFromFormat('H:i', $request->input('duration'));
        $request->merge(['duration' => $duration->minute + ($duration->hour * 60)]);

        $amount = !empty($request->input('amount')) ? $request->input('amount') : 0;
        $request->merge(['amount' => filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT) / 100]);

        $discount = !empty($request->input('discount')) ? $request->input('discount') : 0;
        $request->merge(['discount' => filter_var($discount, FILTER_SANITIZE_NUMBER_FLOAT) / 100]);

        $is_active = !empty($request->input('is_active')) ? true : false;
        $request->merge(['is_active' => $is_active]);

        return $request;
    }

    public function dataTable()
    {
        return DataTables::of(Services::query())
            ->editColumn('amount', function($service){
                return 'R$ '.number_format($service->amount, 2, ',', '.');
            })
            ->editColumn('duration', function($service){
                return $service->duration." minutos";
            })
            ->editColumn('is_active', function($service){
                return $service->is_active ? 'Sim' : 'Não';
            })
            ->addColumn('actions', function ($service){
                return actionsServices($service);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function find($id)
    {
        return Services::find($id);
    }

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $count = Services::where('name', '=', $request->input('name'))
                    ->count();

                if($count > 0)
                    throw new \Exception('Já existe um serviço cadastrado com este nome!');

                $request = $this->formatRequest($request);

                if (!Services::create($request->all()))
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

                $service = Services::find($request->input('id'));
                $service->name = $request->input('name');
                $service->is_active = $request->input('is_active');
                $service->description = $request->input('description');
                $service->amount = $request->input('amount');
                $service->discount = $request->input('discount');
                $service->duration = $request->input('duration');

                if (!$service->save())
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
            $service = Services::find($id);
            $service->delete();

            return [
                'message' => 'Serviço deletado com sucesso!',
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