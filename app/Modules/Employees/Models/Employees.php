<?php

namespace App\Modules\Employees\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model {

    protected $table = 'employees';

    protected $fillable = [
        'name', 'cpf', 'gender', 'birth_date', 'email', 'phone', 'cell_phone', 'color', 'commission', 'is_access_system', 'observation'
    ];

    protected $dates = ['birth_date'];


}
