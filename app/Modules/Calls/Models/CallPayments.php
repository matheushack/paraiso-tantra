<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 08/10/18
 * Time: 14:50
 */

namespace App\Modules\Calls\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\PaymentMethods\Models\PaymentMethods;

class CallPayments extends Model
{
    protected $table = 'call_payments';

    public $timestamps = false;

    protected $fillable = [
        'call_id', 'payment_id', 'amount', 'aliquot', 'date_in_account'
    ];

    public function calls()
    {
        return $this->hasOne(Calls::class, 'id', 'call_id');
    }

    public function payment()
    {
        return $this->hasOne(PaymentMethods::class, 'id', 'payment_id');
    }
}