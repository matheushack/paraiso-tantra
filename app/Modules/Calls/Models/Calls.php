<?php

namespace App\Modules\Calls\Models;

use App\Modules\Services\Models\Services;
use Illuminate\Database\Eloquent\Model;

class Calls extends Model {

    protected $table = 'calls';

    protected $fillable = [
        'unity_id', 'service_id', 'room_id', 'customer_id', 'start', 'end', 'amount', 'discount', 'total'
    ];

    protected $dates = ['start', 'end'];

    public function service()
    {
        return $this->hasMany(Services::class, 'id', 'service_id')->first();
    }

}
