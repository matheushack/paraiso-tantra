<?php

namespace App\Modules\PaymentMethods\Models;

use App\Modules\Accounts\Models\Accounts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethods extends Model {

    use SoftDeletes;

    protected $fillable = ['name', 'account_id'];

    protected $dates = ['deleted_at'];

    public function account()
    {
        return $this->hasMany(Accounts::class, 'id', 'account_id')->first();
    }

}
