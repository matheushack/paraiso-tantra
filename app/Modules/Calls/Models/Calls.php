<?php

namespace App\Modules\Calls\Models;

use App\Modules\Customers\Models\Customers;
use App\Modules\Rooms\Models\Rooms;
use App\Modules\Services\Models\Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calls extends Model
{
    use SoftDeletes;

    protected $table = 'calls';

    protected $fillable = [
        'unity_id', 'service_id', 'room_id', 'customer_id', 'start', 'end', 'status', 'amount', 'discount', 'aliquot', 'total', 'type_discount', 'first_call', 'description', 'date_in_account'
    ];

    protected $dates = ['start', 'end', 'date_in_account', 'deleted_at'];

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
