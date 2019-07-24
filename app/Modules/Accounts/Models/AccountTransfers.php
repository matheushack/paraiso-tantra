<?php

namespace App\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountTransfers extends Model {

    use SoftDeletes;

    protected $table = 'account_transfers';

    protected $fillable = [
        'id', 'account_id', 'is_negative', 'amount', 'description'
    ];

    public function account()
    {
        return $this->hasOne(Accounts::class, 'id', 'account_id');
    }
}
