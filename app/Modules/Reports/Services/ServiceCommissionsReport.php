<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 05/02/19
 * Time: 15:13
 */

namespace App\Modules\Reports\Services;


use App\Modules\Calls\Models\CallEmployees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceCommissionsReport
{
    private function formatRequest(Request $request)
    {
        if(!empty($request->input('start'))) {
            $start = Carbon::createFromFormat('d/m/Y', $request->input('start'))->startOfDay();
            $request->merge(['start' => $start->format('Y-m-d H:i:s')]);
        }

        if(!empty($request->input('end'))) {
            $end = Carbon::createFromFormat('d/m/Y', $request->input('end'))->endOfDay();
            $request->merge(['end' => $end->format('Y-m-d H:i:s')]);
        }

        return $request;
    }

    public function filter(Request $request)
    {
        $request = $this->formatRequest($request);

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
                        WHEN calls.status = "A" THEN "Aguardando pagamento"
                        ELSE "Pago"
                    END as status'),
                DB::raw('
                    CASE
                        WHEN calls.type_discount = "T" THEN "Terapeuta"
                        WHEN calls.type_discount = "C" THEN "Empresa"
                        ELSE "Ambos"
                    END as type_discount'),
                DB::raw('payment_methods.name as payment_method'),
                DB::raw('ROUND(calls.amount - calls.discount) as total'),
                DB::raw('employees.commission as commission'),
                DB::raw('IF(calls.type_discount = "C", ROUND((calls.amount * employees.commission)/100, 2), ROUND(((calls.amount - calls.discount) * employees.commission)/100, 2)) as amountCommission')
            )
            ->join('calls', 'call_employees.call_id', '=', 'calls.id')
            ->join('payment_methods', 'calls.payment_id', '=', 'payment_methods.id')
            ->join('employees', 'call_employees.employee_id', '=', 'employees.id')
            ->join('services', 'calls.service_id', '=', 'services.id')
            ->join('units', 'calls.unity_id', '=', 'units.id');

        if(!empty($request->input('unity_id')))
            $query->whereIn('units.id', $request->input('unity_id'));

        if(!empty($request->input('employees')))
            $query->whereIn('employees.id', $request->input('employees'));

        if(!empty($request->input('service_id')))
            $query->where('services.id', '=', $request->input('service_id'));

        if(!empty($request->input('payment_id')))
            $query->where('calls.payment_id', '=', $request->input('payment_id'));

        if(!empty($request->input('status')))
            $query->where('calls.status', '=', $request->input('status'));

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