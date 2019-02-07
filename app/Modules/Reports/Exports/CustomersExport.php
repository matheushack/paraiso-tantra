<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 11/01/19
 * Time: 15:15
 */

namespace App\Modules\Reports\Exports;

use App\Modules\Reports\Services\ServiceCustomersReport;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CustomersExport implements FromView
{
    public function view(): View
    {
        $request = new Request();
        $serviceCustomers = new ServiceCustomersReport();
        $data = $serviceCustomers->filter($request);

        return view("Reports::export.customers", ['data' => $data]);
    }
}