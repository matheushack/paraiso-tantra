<?php

namespace App\Modules\PaymentMethods\Models;

use App\Modules\Accounts\Models\Accounts;
use App\Traits\OptionSelect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethods extends Model {

    use SoftDeletes, OptionSelect;

    protected $fillable = ['name', 'account_id', 'aliquot'];

    protected $dates = ['deleted_at'];

    public function account()
    {
        return $this->hasMany(Accounts::class, 'id', 'account_id')->first();
    }

}
