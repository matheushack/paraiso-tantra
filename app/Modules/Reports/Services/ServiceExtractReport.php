<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 07/02/19
 * Time: 11:51
 */

namespace App\Modules\Reports\Services;


use App\Modules\Bills\Models\Bills;
use App\Modules\Calls\Models\Calls;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ServiceExtractReport
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

        $calls = Calls::query()
            ->select(
                DB::raw('calls.id AS id'),
                DB::raw('services.name AS name'),
                DB::raw('units.name AS unity'),
                DB::raw('calls.total AS amount'),
                DB::raw('calls.start AS date'),
                DB::raw('0 AS isNegative')
            )
            ->join('services', 'calls.service_id', '=', 'services.id')
            ->join('units', 'calls.unity_id', '=', 'units.id')
            ->where('calls.status', '=', 'P');

        $bills = Bills::query()
            ->select(
                DB::raw('bills.id AS id'),
                DB::raw('providers.name AS name'),
                DB::raw('units.name AS unity'),
                DB::raw('bills.amount AS amount'),
                DB::raw('bills.expiration_date AS date'),
                DB::raw('IF(bills.type = "R", 0, 1) AS isNegative')
            )
            ->join('providers', 'bills.provider_id', '=', 'providers.id')
            ->join('units', 'bills.unity_id', '=', 'units.id')
            ->whereIn('bills.status', ['P', 'R']);

        if(!empty($request->input('unity_id'))) {
            $calls->whereIn('calls.unity_id', $request->input('unity_id'));
            $bills->whereIn('bills.unity_id', $request->input('unity_id'));
        }

        if(!empty($request->input('start')) && !empty($request->input('end'))){
            $calls->where('calls.start', '>=', $request->input('start'))
                ->where('calls.end', '<=', $request->input('end'));
            $bills->whereBetween('bills.expiration_date', [$request->input('start'), $request->input('end')]);
        }else if(!empty($request->input('start'))){
            $calls->where('calls.start', '>=', $request->input('start'));
            $bills->where('bills.expiration_date', '>=', $request->input('start'));
        }else if(!empty($request->input('end'))){
            $calls->where('calls.end', '<=', $request->input('end'));
            $bills->where('bills.expiration_date', '<=', $request->input('end'));
        }

        $total = 0;
        $data = $calls->union($bills)->get();

        $extract = $data->groupBy(function($item) use(&$total){
            $date = Carbon::parse($item->date);

            if($item->isNegative)
                $total = $total - $item->amount;
            else
                $total = $total + $item->amount;

            return $date->format('Y-m-d');
        });

        $extract->sortKeysDesc();
        $extract->put('total', $total);

        return $extract;
    }
}