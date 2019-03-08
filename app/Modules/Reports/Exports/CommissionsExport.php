<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 11/01/19
 * Time: 15:15
 */

namespace App\Modules\Reports\Exports;

use App\Modules\Reports\Services\ServiceCommissionsReport;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CommissionsExport implements FromView
{
    private $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $serviceCommissions = new ServiceCommissionsReport();
        $data = $serviceCommissions->filter($this->request);

        return view("Reports::export.commissions", ['data' => $data]);
    }
}