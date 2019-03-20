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
    private $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $serviceCalls = new ServiceCallsReport();
        $data = $serviceCalls->filter($this->request);

        return view("Reports::export.calls", ['data' => $data]);
    }
}