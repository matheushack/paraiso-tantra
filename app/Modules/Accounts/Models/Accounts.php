<?php

namespace App\Modules\Accounts\Models;

use App\Models\Banks;
use App\Traits\OptionSelect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accounts extends Model {

    use SoftDeletes, OptionSelect;

    protected $table = 'accounts';

    protected $fillable = [
        'id', 'name', 'type', 'bank_id', 'account_type', 'agency_number', 'account_number', 'balance'
    ];

    protected $dates = ['deleted_at'];

    public function bank()
    {
        return $this->hasMany(Banks::class, 'id', 'bank_id')->first();
    }
}
