<?php

namespace App\Modules\Units\Models;

use Illuminate\Database\Eloquent\Model;

class Units extends Model {

    /**
     * @var string
     */
    protected $table = 'units';

    protected $fillable = [
        'cnpj', 'name', 'social_name', 'cep', 'address', 'number', 'complement', 'neighborhood', 'city', 'state', 'email', 'phone', 'cell_phone', 'operating_hours'
    ];

}
