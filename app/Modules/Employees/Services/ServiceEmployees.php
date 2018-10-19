<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 06/10/18
 * Time: 20:04
 */

namespace App\Modules\Employees\Services;

use App\Modules\Calls\Models\CallEmployees;
use App\Modules\Users\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Modules\Employees\Models\Employees;
use Illuminate\Support\Facades\DB as Capsule;

class ServiceEmployees
{
    private function formatRequest(Request $request)
    {
        $birth_date = Carbon::createFromFormat('d/m/Y', $request->input('birth_date'));
        $request->merge(['birth_date' => $birth_date->format('Y-m-d')]);

        $commission = !empty($request->input('commission')) ? $request->input('commission') : 0;
        $request->merge(['commission' => (int) $commission]);

        $is_access_system = !empty($request->input('is_access_system')) ? true : false;
        $request->merge(['is_access_system' => $is_access_system]);

        return $request;
    }

    public function dataTable()
    {
        return DataTables::of(Employees::query())
            ->editColumn('birth_date', function($employee){
                return Carbon::parse($employee->birth_date)->format('d/m/Y');
            })
            ->editColumn('color', function($employee){
                return "<span style='background-color:{$employee->color};width: 15px;height: 15px;display: block;'></span>";
            })
            ->editColumn('commission', function($employee){
                return (int) $employee->commission."%";
            })
            ->editColumn('is_access_system', function($employee){
                return $employee->is_access_system ? 'Sim' : 'Não';
            })
            ->addColumn('actions', function ($employee){
                return actionsEmployees($employee);
            })
            ->rawColumns(['color', 'actions'])
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
                $count = Employees::where('cpf', '=', $request->input('cpf'))
                    ->count();

                if($count > 0)
                    throw new \Exception('Já existe um funcionário cadastrado com este CPF!');

                $request = $this->formatRequest($request);

                $employee = Employees::create($request->all());

                if (!$employee)
                    throw new \Exception('Não foi possível cadastrar um novo serviço. Por favor, tente mais tarde!');

                $user = User::where('email', '=', $request->input('email'))->withTrashed()->first();

                if($request->input('is_access_system') && !$user) {
                    $user = [
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => 'paraiso123'
                    ];

                    if (!User::create($user))
                        throw new \Exception('Não foi possível cadastrar o funcionário para acessar o sistema. Por favor, tente mais tarde!');

                }else if($request->input('is_access_system')){
                    $user->deleted_at = null;
                    $user->password = 'paraiso1234';

                    $user->save();
                }
            });

            return [
                'message' => 'Funcionário cadastrado com sucesso!',
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
                $acessSystemBefore = $employee->is_access_system;

                $employee->name = $request->input('name');
                $employee->cpf = $request->input('cpf');
                $employee->gender = $request->input('gender');
                $employee->birth_date = $request->input('birth_date');
                $employee->email = $request->input('email');
                $employee->phone = $request->input('phone');
                $employee->cell_phone = $request->input('cell_phone');
                $employee->color = $request->input('color');
                $employee->commission = $request->input('commission');
                $employee->is_access_system = $request->input('is_access_system');
                $employee->observation = $request->input('observation');



                if (!$employee->save())
                    throw new \Exception('Não foi possível editar o funcionário. Por favor, tente mais tarde!');

                $user = User::where('email', '=', $request->input('email'))->withTrashed()->first();

                if($user) {
                    if(!$request->input('is_access_system') && $acessSystemBefore == 1)
                        $user->deleted_at = Carbon::now();
                    else
                        $user->deleted_at = null;

                    $user->save();
                }
            });

            return [
                'message' => 'Funcionário editado com sucesso!',
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

    public function availability(Request $request)
    {
        try {
            $employeesBusy = CallEmployees::from('call_employees as Ce')
                ->join('calls AS C', 'Ce.call_id', '=', 'C.id')
                ->where(function ($query) use ($request) {
                    $query->whereRaw(DB::raw("'".$request->input('start')."' between C.start and C.end"))
                        ->orWhereRaw(DB::raw("'".$request->input('end')."' between C.start and C.end"));
                })
                ->get();

            if($employeesBusy->count() == 0){
                return Employees::all();
            }

            $employees = [];

            $employeesBusy->each(function($item) use(&$employees){
                $employees[] = $item->employee_id;
            });

            return Employees::whereNotIn('id', $employees)->get();
        }catch(\Exception $e){
            return false;
        }
    }

}