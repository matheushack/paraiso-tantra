<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 05/09/18
 * Time: 17:05
 */

namespace App\Modules\Users\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\Users\Models\User;
use Illuminate\Support\Facades\DB as Capsule;

/**
 * Class ServiceUsers
 * @package App\Modules\Users\Services
 */
class ServiceUsers
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTable()
    {
        return DataTables::of(User::query())
            ->editColumn('img_profile',  function ($user) {
                return imgProfileUsers($user);
            })
            ->editColumn('created_at',  function ($user) {
                return Carbon::parse($user->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('actions', function ($user){
                return actionsUsers($user);
            })
            ->rawColumns(['img_profile', 'created_at', 'actions'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            Capsule::transaction(function () use ($request) {
                if(User::where('email', '=', $request->input('email'))->count() > 0)
                    throw new \Exception('Já existe um usuário com o email informado!');

                if (!User::create($request->all()))
                    throw new \Exception('Não foi possível cadastrar um novo usuário. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Usuário cadastrado com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }
}