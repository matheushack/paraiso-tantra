<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 05/02/19
 * Time: 15:13
 */

namespace App\Modules\Reports\Services;


use App\Modules\Calls\Models\Calls;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceCustomersReport
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

        $query = Calls::query()
            ->select(
                'calls.start', 'calls.end',
                DB::raw('services.name as service'),
                'customers.name', 'customers.phone', 'customers.cell_phone',
                DB::raw('GROUP_CONCAT(employees.name) as employees'),
                DB::raw('units.name as unity')
            )
            ->join('services', 'calls.service_id', '=', 'services.id')
            ->join('call_employees', 'calls.id', '=', 'call_employees.call_id')
            ->join('employees', 'call_employees.employee_id', '=', 'employees.id')
            ->join('customers', 'calls.customer_id', '=', 'customers.id')
            ->join('units', 'calls.unity_id', '=', 'units.id');

        if(!empty($request->input('customer_id')))
            $query->where('customers.id', '=', $request->input('customer_id'));

        if(!empty($request->input('phone')))
            $query->where('customers.phone', '=', $request->input('phone'));

        if(!empty($request->input('cell_phone')))
            $query->where('customers.cell_phone', '=', $request->input('cell_phone'));

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

        return $query->groupBy('calls.id')
            ->orderBy('calls.start')
            ->get();
    }
}