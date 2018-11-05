<?php

namespace App\Modules\Services\Models;

use App\Traits\OptionSelect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use SoftDeletes, OptionSelect;

    protected $table = 'services';

    protected $fillable = [
        'name', 'description', 'amount', 'discount', 'duration', 'is_active'
    ];

    protected $dates = ['deleted_at'];

}
