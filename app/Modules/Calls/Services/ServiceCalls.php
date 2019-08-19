<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 08/09/18
 * Time: 22:07
 */

namespace App\Modules\Calls\Services;


use App\Modules\Calls\Constants\StatusPayment;
use App\Modules\Calls\Models\CallEmployees;
use App\Modules\PaymentMethods\Models\PaymentMethods;
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
        $start = Carbon::createFromFormat('d/m/Y H:i', $request->input('start'))->addSecond(1);
        $end = Carbon::createFromFormat('d/m/Y H:i', $request->input('start'))->addMinutes($service->duration)->subSeconds(1);

        $request->merge(['start' => $start->format('Y-m-d H:i:s')]);
        $request->merge(['end' => $end->format('Y-m-d H:i:s')]);
        $request->merge(['duration' => $service->duration]);

        return $request;
    }

    private function formatRequestFinancial(Request $request)
    {
        $amount = !empty($request->input('amount')) ? $request->input('amount') : 0;
        $request->merge(['amount' => filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT) / 100]);

        $discount = !empty($request->input('discount')) ? $request->input('discount') : 0;
        $request->merge(['discount' => filter_var($discount, FILTER_SANITIZE_NUMBER_FLOAT) / 100]);

        $aliquot = PaymentMethods::find($request->input('payment_id'))->aliquot;
        $request->merge(['aliquot' => filter_var($aliquot, FILTER_SANITIZE_NUMBER_FLOAT) / 100]);

        $typeDiscount = !empty($request->input('type_discount')) ? $request->input('type_discount') : null;
        $request->merge(['type_discount' => $typeDiscount]);

        $request->merge(['total' => $request->input('amount') - $request->input('discount')]);

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
            $title = !empty($call->service()->name) ? $call->service()->name : "Serviço não identificado";
            $title .= " - ";
            $title .= !empty($call->room()->name) ? $call->room()->name : "Serviço não identificado";
            $title .= PHP_EOL.'Cliente: ';
            $title .= !empty($call->customer()->name) ? $call->customer()->name : "Não identificado";
            $title .= PHP_EOL;

            $calendar[] = [
                'id' => $call->id,
                'title' => $title,
                'description' => 'Terapeutas: '.implode('/', $employees),
                'start' => $call->start->format('Y-m-d H:i:s'),
                'end' => $call->end->format('Y-m-d H:i:s'),
                'backgroundColor' => '#'.$color,
                'borderColor' => '#'.$color,
                'paid' => $call->status == StatusPayment::PAID ? true : false,
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

    public function update(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $request = $this->formatRequest($request);

                $call = Calls::find($request->input('call_id'));

                if($call->count() == 0)
                    throw new \Exception('Atendimento não encontrado!');

                if($call->service_id != $request->input('service_id')){
                    $service = Services::find($request->input('service_id'));
                    $total = $service->amount - $call->discount;
                    $total = $total - ($call->aliquot * $total)/100;

                    if($total < 0)
                        throw new \Exception('O valor total ficará negativo, por favor verifique!');

                    $call->amount = $service->amount;
                    $call->total = $total;
                }

                $call->unity_id = $request->input('unity_id');
                $call->service_id = $request->input('service_id');
                $call->room_id = $request->input('room_id');
                $call->customer_id = $request->input('customer_id');
                $call->first_call = $request->input('first_call');
                $call->description = $request->input('description');
                $call->start = $request->input('start');
                $call->end = $request->input('end');

                if(!$call->save())
                    throw new \Exception('Houve um problema ao tentar atualziar o atendimento. Por favor, tente mais tarde!');

                if(!$this->destroyCallEmployees($call))
                    throw new \Exception('Houve um problema ao tentar atualziar os terapeutas do atendimento. Por favor, tente mais tarde!');

                foreach($request->input('employees') as $employee){
                    if(!CallEmployees::create(['call_id' => $call->id, 'employee_id' => $employee]))
                        throw new \Exception('Houve um problema ao tentar atualziar os terapeutas do atendimento. Por favor, tente mais tarde!');
                }


            });

            $call = Calls::find($request->input('call_id'));

            return [
                'callId' => $call->id,
                'paid' => $call->status == 'P' ? true : false,
                'message' => 'Atendimento atualizado com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }

    public function updateFinancial(Request $request)
    {
        try {
            Capsule::transaction(function() use ($request) {
                $request = $this->formatRequestFinancial($request);

                $call = Calls::find($request->input('call_id'));

                if($call->count() == 0)
                    throw new \Exception('Atendimento não encontrado!');

                $total = $request->input('amount') - $request->input('discount');
                $total = $total - ($request->input('aliquot') * $total)/100;

                if($total < 0)
                    throw new \Exception('O valor total ficará negativo, por favor verifique!');

                $call->status = $request->input('status');
                $call->payment_id = $request->input('payment_id');
                $call->type_discount = $request->input('type_discount');
                $call->amount = $request->input('amount');
                $call->discount = $request->input('discount');
                $call->aliquot = $request->input('aliquot');
                $call->total = $total;

                if($request->input('status') == 'P' && empty($call->date_in_account) && $request->input('payment_id')){
                    $payment = PaymentMethods::find($request->input('payment_id'));
                    $call->date_in_account = Carbon::now()->addDays($payment->days_in_account)->format('Y-m-d');
                }

                if(!$call->save())
                    throw new \Exception('Houve um problema ao tentar atualziar o atendimento. Por favor, tente mais tarde!');
            });

            $call = Calls::find($request->input('call_id'));

            return [
                'callId' => $call->id,
                'paid' => $call->status == 'P' ? true : false,
                'message' => 'Atendimento atualizado com sucesso!',
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
                'room_id' => ($request->input('room_id_edit') ? $request->input('room_id_edit') : ''),
                'employees_id_edit' => ($request->input('employees_id_edit') ? $request->input('employees_id_edit') : ''),
                'html' => (string) View::make('Calls::availability', [
                    'status' => 'success',
                    'rooms' => $rooms,
                    'room_id' => ($request->input('room_id_edit') ? $request->input('room_id_edit') : ''),
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

    public function destroyCallEmployees(Calls $call)
    {
        return CallEmployees::where('call_id', '=', $call->id)
            ->delete();
    }

}
