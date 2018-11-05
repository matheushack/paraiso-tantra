<?php

namespace App\Modules\Employees\Models;

use App\Traits\OptionSelect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employees extends Model
{
    use SoftDeletes, OptionSelect;

    protected $table = 'employees';

    protected $fillable = [
        'name', 'cpf', 'gender', 'birth_date', 'email', 'phone', 'cell_phone', 'color', 'commission', 'is_access_system', 'observation'
    ];

    protected $dates = ['birth_date','deleted_at'];


}
