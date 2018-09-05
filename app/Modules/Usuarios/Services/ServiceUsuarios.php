<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 05/09/18
 * Time: 17:05
 */

namespace App\Modules\Usuarios\Services;

use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use App\Modules\Usuarios\Models\Usuarios;

class ServiceUsuarios
{
    public function dataTable()
    {
        return DataTables::of(Usuarios::query())
            ->editColumn('created_at',  function ($usuarios) {
                return Carbon::parse($usuarios->created_at)->format('d/m/Y H:i:s');
            })
//            ->editColumn('type', function($enterprise){
//
//                return $enterprise->type();
//            })
//            ->editColumn('category', function($enterprise){
//                return $enterprise->category();
//            })
            ->addColumn('actions', function ($usuarios){
                return '
                    actions
                ';
            })
            ->rawColumns(['created_at', 'actions'])
            ->make(true);
    }
}