<?php

namespace App\Modules\Customers\Models;

use App\Traits\OptionSelect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use SoftDeletes, OptionSelect;

    protected $table = 'customers';

    protected $fillable = [
        'name', 'email', 'phone', 'cell_phone', 'gender'
    ];

    protected $dates = ['deleted_at'];

}
