<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'name', 'email', 'phone', 'cell_phone', 'gender'
    ];

    protected $dates = ['deleted_at'];

    public static function optionSelect()
    {
        $array = [];
        $units = self::all();
        $units->each(function ($item) use(&$array){
            $array[$item->id] = $item->name;
        });

        return $array;
    }

}
