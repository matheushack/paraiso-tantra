<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 11/01/19
 * Time: 15:15
 */

namespace App\Modules\Reports\Exports;

use App\Modules\Reports\Services\ServiceCallsReport;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CallsExport implements FromView
{
    public function view(): View
    {
        $request = new Request();
        $serviceCalls = new ServiceCallsReport();
        $data = $serviceCalls->filter($request);

        return view("Reports::export.calls", ['data' => $data]);
    }
}