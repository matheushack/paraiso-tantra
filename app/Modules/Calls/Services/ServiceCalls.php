<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 08/09/18
 * Time: 22:07
 */

namespace App\Modules\Calls\Services;


use App\Modules\Calls\Models\CallEmployees;
use Carbon\Carbon;
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

        $request->merge(['start' => $start->format('Y-m-d H:i:s')]);
        $request->merge(['end' => $end->format('Y-m-d H:i:s')]);
        $request->merge(['duration' => $service->duration]);
        $request->merge(['amount' => $service->amount]);
        $request->merge(['discount' => $service->discount]);
        $request->merge(['total' => $service->amount - $service->discount]);

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

    /**
     * @return string
     */
    public function calendar()
    {
        $calendar = [];
        $calls = Calls::all();

        foreach($calls as $call){
            $calendar[] = [
                'id' => $call->id,
                'title' => $call->service()->name,
                'start' => Carbon::parse($call->start)->timestamp,
                'end' => Carbon::parse($call->end)->timestamp,
                'backgroundColor' => 'red',
                'borderColor' => 'red'
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
                'employees' => 'required',
                'start' => 'required'
            ]);

            $request = $this->formatRequestAvailability($request);

            if(!app(ServiceEmployees::class)->availability($request))
                throw new \Exception('employees');

            $rooms = app(Rooms::class)->where('unity_id', '=', $request->input('unity_id'))->get();

            return [
                'success' => true,
                'html' => (string) View::make('Calls::availability', [
                    'status' => 'success',
                    'rooms' => $rooms,
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
}