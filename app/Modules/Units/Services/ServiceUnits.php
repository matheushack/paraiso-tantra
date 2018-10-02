<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 01/10/18
 * Time: 22:02
 */

namespace App\Modules\Units\Services;

use App\Modules\Units\Models\Units;
use Yajra\DataTables\DataTables;

class ServiceUnits
{
    public function dataTable()
    {
        return DataTables::of(Units::query())
            ->addColumn('actions', function ($unity){
                return actionsUnits($unity);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}