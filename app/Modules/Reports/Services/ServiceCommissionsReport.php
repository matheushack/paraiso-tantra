<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 05/02/19
 * Time: 15:13
 */

namespace App\Modules\Reports\Services;


use App\Modules\Calls\Models\CallEmployees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceCommissionsReport
{
    public function filter(Request $request)
    {
        $query = CallEmployees::query()
            ->select(
                DB::raw('units.name as unity'),
                DB::raw('services.name as service'),
                DB::raw('calls.start as start'),
                DB::raw('calls.end as end'),
                DB::raw('employees.name as employee'),
                DB::raw('calls.amount as amount'),
                DB::raw('calls.discount as discount'),
                DB::raw('
                    CASE
                        WHEN calls.type_discount = "T" THEN "Terapeuta"
                        WHEN calls.type_discount = "C" THEN "Empresa"
                        ELSE "Ambos"
                    END as type_discount'),
                DB::raw('ROUND(calls.amount - calls.discount) as total'),
                DB::raw('employees.commission as commission'),
                DB::raw('IF(calls.type_discount <> "T", ROUND((calls.amount * employees.commission)/100, 2), ROUND(((calls.amount - calls.discount) * employees.commission)/100, 2)) as amountCommission')
            )
            ->join('calls', 'call_employees.call_id', '=', 'calls.id')
            ->join('employees', 'call_employees.employee_id', '=', 'employees.id')
            ->join('services', 'calls.service_id', '=', 'services.id')
            ->join('units', 'calls.unity_id', '=', 'units.id')
            ->where('calls.status', '=', 'P');

        if(!empty($request->input('unity_id')))
            $query->whereIn('units.id', $request->input('unity_id'));

        if(!empty($request->input('employees')))
            $query->whereIn('employees.id', $request->input('employees'));

        if(!empty($request->input('service_id')))
            $query->where('services.id', '=', $request->input('service_id'));

        if(!empty($request->input('start')) && !empty($request->input('end'))){
            $query->where('calls.start', '>=', $request->input('start'))
                ->where('calls.end', '<=', $request->input('end'));
        }else if(!empty($request->input('start'))){
            $query->where('calls.start', '>=', $request->input('start'));
        }else if(!empty($request->input('end'))){
            $query->where('calls.end', '<=', $request->input('end'));
        }

        return $query->orderBy('calls.start')
            ->get();
    }
}