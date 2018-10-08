<?php

namespace App\Modules\Calls\Models;

use Illuminate\Database\Eloquent\Model;

class Calls extends Model {

    protected $table = 'calls';

    protected $fillable = [
        'unity_id', 'service_id', 'room_id', 'customer_id', 'start', 'end', 'amount', 'discount', 'total'
    ];

    protected $dates = ['start', 'end'];

}
