<?php

namespace App\Modules\Rooms\Models;

use App\Modules\Units\Models\Units;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rooms extends Model
{
    use SoftDeletes;

    protected $table = 'rooms';

    protected $fillable = [
        'name', 'unity_id', 'is_active'
    ];

    protected $dates = ['deleted_at'];

    public function unity()
    {
        return $this->hasMany(Units::class, 'id', 'unity_id')->first();
    }

}
