<?php

namespace App\Modules\Bills\Models;

use App\Modules\PaymentMethods\Models\PaymentMethods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bills extends Model {

    use SoftDeletes;

    protected $table = 'bills';

    protected $fillable = [
        'name', 'payment_id', 'type', 'expiration_date', 'amount', 'description'
    ];

    public function payment()
    {
        return $this->hasOne(PaymentMethods::class, 'id', 'payment_id');
    }

}
