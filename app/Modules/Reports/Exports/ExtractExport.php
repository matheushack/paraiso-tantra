<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 11/01/19
 * Time: 15:15
 */

namespace App\Modules\Reports\Exports;

use App\Modules\Reports\Services\ServiceExtractReport;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class ExtractExport implements FromView
{
    public function view(): View
    {
        $request = new Request();
        $serviceExtract = new ServiceExtractReport();
        $data = $serviceExtract->filter($request);

        return view("Reports::export.extract", ['extract' => $data]);
    }
}