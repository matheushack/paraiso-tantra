<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 08/09/18
 * Time: 22:07
 */

namespace App\Modules\Calls\Services;


use App\Modules\Calls\Models\CallEmployees;
use App\Modules\Rooms\Services\ServiceRooms;
use Carbon\Carbon;
use Grpc\Call;
use Illuminate\Http\Request;
use App\Modules\Rooms\Models\Rooms;
use App\Modules\Calls\Models\Calls;
use Illuminate\Support\Facades\View;
use App\Modules\Services\Models\Services;
use Illuminate\Support\Facades\DB as Capsule;
use Illuminate\Validation\ValidationException;
use App\Modules\Employees\Services\ServiceEmployees;

/**
 * Class ServiceCalls
 * @package App\Modules\Calls\Services
 */
class ServiceCalls
{
    private function formatRequest(Request $request)
    {
        $service = Services::find($request->input('service_id'));
        $start = Carbon::createFromFormat('d/m/Y H:i', $request->input('start'));
        $end = Carbon::createFromFormat('d/m/Y H:i', $request->input('start'))->addMinutes($service->duration);
        $firstCall = !empty($request->input('first_call')) ? true : false;

        $request->merge(['start' => $start->format('Y-m-d H:i:s')]);
        $request->merge(['end' => $end->format('Y-m-d H:i:s')]);
        $request->merge(['duration' => $service->duration]);
        $request->merge(['amount' => $service->amount]);
        $request->merge(['discount' => $service->discount]);
        $request->merge(['total' => $service->amount - $service->discount]);
        $request->merge(['first_call' => $firstCall]);

        return $request;
    }

    private function formatRequestAvailability(Request $request)
    {
        $service = Services::find($request->input('service_id'));
        $start = Carbon::createFromFormat('d/m/Y H:i', $request->input('start'));
        $end = Carbon::createFromFormat('d/m/Y H:i', $request->input('start'))->addMinutes($service->duration);

        $request->merge(['start' => $start->format('Y-m-d H:i:s')]);
        $request->merge(['end' => $end->format('Y-m-d H:i:s')]);
        $request->merge(['duration' => $service->duration]);

        return $request;
    }

    public function find($id)
    {
        return Calls::find($id);
    }

    /**
     * @return string
     */
    public function calendar(Request $request)
    {
        $calendar = [];
        $calls = Calls::where('unity_id', '=', $request->input('unity_id'))->get();

        if($calls->count() == 0)
            return [];

        foreach($calls as $call){
            $colors = [];
            $employees = [];

            $call->employees->each(function($item) use(&$colors, &$employees){
                $colors[] = hexdec($item->employee()->color);
                $employees[] = $item->employee()->name;
            });

            $color = dechex(array_sum($colors));
            $color = strlen($color) == 6 ? $color : str_pad($color, 6, 0, STR_PAD_LEFT);
            $color = substr($color,0, 6);

            $calendar[] = [
                'id' => $call->id,
                'title' => $call->service()->name.' - '.$call->room()->name.PHP_EOL.'Cliente: '.$call->customer()->name.PHP_EOL,
                'description' => 'Terapeutas: '.implode('/', $employees),
                'start' => $call->start->format('Y-m-d H:i:s'),
                'end' => $call->end->format('Y-m-d H:i:s'),
                'backgroundColor' => '#'.$color,
                'borderColor' => '#'.$color,
                'textColor' => isBright($color) ? '#000000' : '#FFFFFF'
            ];
        }

        return $calendar;
    }

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $request = $this->formatRequest($request);

                $count = Calls::where('customer_id', '=', $request->input('customer_id'))
                    ->where('start', '=', $request->input('start'))
                    ->count();

                if($count > 0)
                    throw new \Exception('Já existe um atendimento cadastrado com para este cliente neste horário!');

                $call = Calls::create($request->all());

                if (!$call)
                    throw new \Exception('Não foi possível cadastrar um novo atendimento. Por favor, tente mais tarde!');

                foreach($request->input('employees') as $employee){
                    if(!CallEmployees::create(['call_id' => $call->id, 'employee_id' => $employee]))
                        throw new \Exception('Não foi possível cadastrar um novo atendimento. Por favor, tente mais tarde!');
                }
            });

            return [
                'message' => 'Atendimento cadastrado com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }

    public function availability(Request $request)
    {
        try {
            $request->validate([
                'unity_id' => 'required',
                'service_id' => 'required',
                'start' => 'required'
            ]);

            $request = $this->formatRequestAvailability($request);

            $employees = app(ServiceEmployees::class)->availability($request);

            if($employees->count() == 0)
                throw new \Exception('employees');

            $rooms = app(ServiceRooms::class)->availability($request);

            if($rooms->count() == 0)
                throw new \Exception('rooms');

            return [
                'success' => true,
                'html' => (string) View::make('Calls::availability', [
                    'status' => 'success',
                    'rooms' => $rooms,
                    'employees' => $employees,
                    'duration' => $request->input('duration'),
                    'end' => Carbon::parse($request->input('end'))->format('d/m/Y H:i')
                ])
            ];
        }catch (ValidationException $e){
            return [
                'success' => false,
                'html' => (string) View::make('Calls::availability', ['status' => 'validation'])
            ];
        }catch (\Exception $e){
            return [
                'success' => false,
                'html' => (string) View::make('Calls::availability', ['status' => $e->getMessage()])
            ];
        }
    }

    public function destroy($id)
    {
        try {
            $call = Calls::find($id);
            $call->delete();

            return [
                'message' => 'Atendimento deletado com sucesso!',
                'deleted' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'deleted' => false
            ];
        }
    }

}