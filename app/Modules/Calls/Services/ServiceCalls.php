<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 08/09/18
 * Time: 22:07
 */

namespace App\Modules\Calls\Services;


use App\Modules\Employees\Services\ServiceEmployees;
use App\Modules\Rooms\Models\Rooms;
use App\Modules\Services\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

/**
 * Class ServiceCalls
 * @package App\Modules\Calls\Services
 */
class ServiceCalls
{
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
        return [
            [
                'title' => 'Massagem 1',
                'start' => Carbon::create('2018', '09', '08', '15', '00', '00')->timestamp,
                'end' => Carbon::create('2018', '09', '08', '15', '30', '00')->timestamp,
                'backgroundColor' => 'red',
                'borderColor' => 'red'
            ],
            [
                'title' => 'Massagem 2',
                'start' => Carbon::create('2018', '09', '08', '15', '30', '00')->timestamp,
                'end' => Carbon::create('2018', '09', '08', '16', '00', '00')->timestamp,
                'backgroundColor' => 'blue',
                'borderColor' =>'blue'
            ],
        ];
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
                    'duration' => $request->input('duration')
                ])
            ];
        }catch (ValidationException $e){
            return [
                'success' => false,
                'html' => (string) View::make('Calls::availability', ['status' => 'validation'])
            ];
        }catch (\Exception $e){
            dd($e->getMessage());
            return [
                'success' => false,
                'html' => (string) View::make('Calls::availability', ['status' => $e->getMessage()])
            ];
        }
    }
}