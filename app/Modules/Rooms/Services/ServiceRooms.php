<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 06/10/18
 * Time: 12:45
 */

namespace App\Modules\Rooms\Services;

use App\Modules\Calls\Models\Calls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Modules\Rooms\Models\Rooms;
use Illuminate\Support\Facades\DB as Capsule;

class ServiceRooms
{
    public function dataTable()
    {
        return DataTables::of(Rooms::query())
            ->addColumn('unity', function ($room){
                return $room->unity()->name;
            })
            ->editColumn('is_active', function($room){
                return $room->is_active ? 'Sim' : 'Não';
            })
            ->addColumn('actions', function ($room){
                return actionsRooms($room);
            })
            ->rawColumns(['unity','actions'])
            ->make(true);
    }

    public function find($id)
    {
        return Rooms::find($id);
    }

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $count = Rooms::where('name', '=', $request->input('name'))
                    ->where('unity_id', '=', $request->input('unity_id'))
                    ->count();

                if($count > 0)
                    throw new \Exception('Já existe uma sala cadastrada para a unidade selecionada!');

                $isActive = !empty($request->input('is_active')) ? true : false;
                $request->merge(['is_active' => $isActive]);

                if (!Rooms::create($request->all()))
                    throw new \Exception('Não foi possível cadastrar uma nova sala. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Sala cadastrada com sucesso!',
                'save' => true
            ];
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
                $room = Rooms::find($request->input('id'));
                $room->name = $request->input('name');
                $room->unity_id = $request->input('unity_id');
                $room->is_active = !empty($request->input('is_active')) ? true : false;

                if (!$room->save())
                    throw new \Exception('Não foi possível editar a sala. Por favor, tente mais tarde!');
            });

            return [
                'message' => 'Sala editada com sucesso!',
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
            $room = Rooms::find($id);
            $room->delete();

            return [
                'message' => 'Sala deletada com sucesso!',
                'deleted' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'deleted' => false
            ];
        }
    }

    public function availability(Request $request)
    {
        try {
            $availabilitySub = $this->availabilitySub($request);

            $query = Rooms::select('*')
                ->where('unity_id', '=', $request->input('unity_id'))
                ->where('is_active', '=', 1);

            if($availabilitySub->count() > 0) {
                $roomsCalls = [];
                $availabilitySub->each(function($item) use(&$roomsCalls){
                    $roomsCalls[] = $item->unity_id;
                });

                $query->whereNotIn('id', $roomsCalls);
            }

           return $query->get();
        }catch(\Exception $e){
            return false;
        }
    }

    private function availabilitySub(Request $request)
    {
        return Calls::select('unity_id')
            ->where('unity_id', '=', $request->input('unity_id'))
            ->where(function ($query) use ($request) {
                $query->whereRaw(DB::raw("'".$request->input('start')."' between start and end"))
                    ->orWhereRaw(DB::raw("'".$request->input('end')."' between start and end"));
            })->get();
    }


}