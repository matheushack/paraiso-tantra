<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 06/10/18
 * Time: 23:58
 */

namespace App\Modules\Customers\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use App\Modules\Customers\Models\Customers;
use Illuminate\Support\Facades\DB as Capsule;

class ServiceCustomers
{
    public function dataTable()
    {
        return DataTables::of(Customers::query())
            ->addColumn('actions', function ($customer){
                return actionsCustomers($customer);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function find($id)
    {
        return Customers::find($id);
    }

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $count = Customers::where('name', '=', $request->input('name'))
                    ->count();

                if($count > 0)
                    throw new \Exception('Já existe um cliente cadastrado com este nome!');

                if (!Customers::create($request->all()))
                    throw new \Exception('Não foi possível cadastrar um novo cliente. Por favor, tente mais tarde!');
            });

            $select2 = [];

            if(!empty($request->input('select2')))
                $select2 = [
                    'text' => $request->input('name'),
                    'id' => Customers::orderBy('created_at', 'desc')->first()->id
                ];

            return [
                'message' => 'Cliente cadastrado com sucesso!',
                'save' => true
            ] + $select2;
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }

    public function update(Request $request)
    {
        try {
            Capsule::transaction(function () use ($request) {

                $customer = Customers::find($request->input('id'));
                $customer->name = $request->input('name');
                $customer->email = $request->input('email');
                $customer->phone = $request->input('phone');
                $customer->cell_phone = $request->input('cell_phone');
                $customer->gender = $request->input('gender');

                if (!$customer->save())
                    throw new \Exception('Não foi possível editar o cliente. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Cliente editado com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }

    public function destroy($id)
    {
        try {
            $customer = Customers::find($id);
            $customer->delete();

            return [
                'message' => 'Cliente deletado com sucesso!',
                'deleted' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'deleted' => false
            ];
        }
    }

    public function search(Request $request)
    {
        try {
            $query = Customers::select('*');

            if($request->input('name'))
                $query->where('name', 'like', '%'.$request->input('name').'%');

            if($request->input('email'))
                $query->where('email', '=', $request->input('email'));

            if($request->input('phone'))
                $query->where('phone', '=', $request->input('phone'));

            if($request->input('cell_phone'))
                $query->where('cell_phone', '=', $request->input('cell_phone'));

            if($request->input('gender'))
                $query->where('gender', '=', $request->input('gender'));

            if($request->input('autocomplete')){
				$query->where('name', 'like', '%'.$request->input('autocomplete').'%')
					->orWhere('email', 'like', '%'.$request->input('autocomplete').'%')
					->orWhere('phone', 'like', '%'.$request->input('autocomplete').'%')
					->orWhere('cell_phone', 'like', '%'.$request->input('autocomplete').'%');
			}

            $customers = $query->get();

            if($customers->count() == 0)
                throw new \Exception('404');

			$response = [
				'success' => true,
				'data' => $customers->transform(function($customer){
					return [
						'id' => $customer->id,
						'text' => $customer->name
					];
				})
			];

            if(empty($request->input('json'))){
				$response = [
					'success' => true,
					'html' => (string) View::make('Customers::components.search', [
						'status' => 'success',
						'customers' => $query->get()
					])
				];
			}

        }catch (\Exception $e){
			$response = [
				'success' => false
			];

			if(empty($request->input('json'))) {
				$response = [
					'success' => false,
					'html' => (string)View::make('Customers::components.search', ['status' => $e->getMessage()])
				];
			}
        }

        return $response;
    }
}