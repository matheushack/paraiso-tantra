<?php

namespace App\Modules\Bills\Models;

use App\Modules\PaymentMethods\Models\PaymentMethods;
use App\Modules\Units\Models\Units;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bills extends Model {

    use SoftDeletes;

    protected $table = 'bills';

    protected $fillable = [
        'provider_id', 'payment_id', 'unity_id', 'type', 'expiration_date', 'amount', 'description'
    ];

    public function provider()
    {
        return $this->hasOne(Providers::class, 'id', 'provider_id');
    }

    public function payment()
    {
        return $this->hasOne(PaymentMethods::class, 'id', 'payment_id');
    }

    public function unity()
    {
        return $this->hasOne(Units::class, 'id', 'unity_id');
    }

}
