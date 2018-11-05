<?php

namespace App\Modules\Units\Models;

use App\Traits\OptionSelect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Units extends Model
{
    use SoftDeletes, OptionSelect;

    /**
     * @var string
     */
    protected $table = 'units';

    protected $fillable = [
        'cnpj', 'name', 'social_name', 'cep', 'address', 'number', 'complement', 'neighborhood', 'city', 'state', 'email', 'phone', 'cell_phone', 'operating_hours'
    ];

    protected $dates = ['deleted_at'];

}
