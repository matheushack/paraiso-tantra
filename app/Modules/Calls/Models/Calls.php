<?php

namespace App\Modules\Calls\Models;

use App\Modules\Customers\Models\Customers;
use App\Modules\Rooms\Models\Rooms;
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

    public function room()
    {
        return $this->hasMany(Rooms::class, 'id', 'room_id')->first();
    }

    public function customer()
    {
        return $this->hasMany(Customers::class, 'id', 'customer_id')->first();
    }

    public function employees()
    {
        return $this->hasMany(CallEmployees::class, 'call_id', 'id');
    }

}
