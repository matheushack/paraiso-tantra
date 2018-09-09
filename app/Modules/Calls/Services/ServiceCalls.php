<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 08/09/18
 * Time: 22:07
 */

namespace App\Modules\Calls\Services;


use Carbon\Carbon;

/**
 * Class ServiceCalls
 * @package App\Modules\Calls\Services
 */
class ServiceCalls
{
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
}