<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model {

    protected $table = 'customers';

    protected $fillable = [
        'name', 'email', 'phone', 'cell_phone'
    ];


}
