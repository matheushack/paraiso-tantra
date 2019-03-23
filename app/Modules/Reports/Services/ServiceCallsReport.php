<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 07/02/19
 * Time: 11:51
 */

namespace App\Modules\Reports\Services;


use App\Modules\Calls\Models\Calls;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceCallsReport
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
            ->select([
                DB::raw('customers.name as customer'),
                DB::raw('units.name as unity'),
                DB::raw('rooms.name as room'),
                DB::raw('GROUP_CONCAT(employees.name) as employees'),
                DB::raw('payment_methods.name as payment_method'),
                DB::raw('services.name as service'),
                DB::raw('calls.start'),
                DB::raw('calls.end'),
                DB::raw('calls.status'),
                DB::raw('calls.amount'),
                DB::raw('calls.aliquot'),
                DB::raw('calls.discount'),
                DB::raw('calls.total'),
                DB::raw('calls.date_in_account'),
            ])
            ->join('units', 'calls.unity_id', '=', 'units.id')
            ->join('services', 'calls.service_id', '=', 'services.id')
            ->join('rooms', 'calls.room_id', '=', 'rooms.id')
            ->leftJoin('payment_methods', 'calls.payment_id', '=', 'payment_methods.id')
            ->join('customers', 'calls.customer_id', '=', 'customers.id')
            ->join('call_employees', 'calls.id', '=', 'call_employees.call_id')
            ->join('employees', 'call_employees.employee_id', '=', 'employees.id');

        if(!empty($request->input('customer_id')))
            $query->where('customers.id', '=', $request->input('customer_id'));

        if(!empty($request->input('unity_id')))
            $query->whereIn('units.id', $request->input('unity_id'));

        if(!empty($request->input('employees')))
            $query->whereIn('employees.id', $request->input('employees'));

        if(!empty($request->input('status')))
            $query->where('calls.status', '=', $request->input('status'));

        if(!empty($request->input('payment_id')))
            $query->where('calls.payment_id', '=', $request->input('payment_id'));

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
