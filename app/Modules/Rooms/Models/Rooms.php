<?php

namespace App\Modules\Rooms\Models;

use App\Modules\Units\Models\Units;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model {

    protected $table = 'rooms';

    protected $fillable = [
        'name', 'unity_id', 'is_active'
    ];

    public function unity()
    {
        return $this->hasMany(Units::class, 'id', 'unity_id')->first();
    }

}
