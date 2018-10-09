<?php

namespace App\Modules\Customers\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model {

    protected $table = 'customers';

    protected $fillable = [
        'name', 'email', 'phone', 'cell_phone'
    ];

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
