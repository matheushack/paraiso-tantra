<?php

namespace App\Modules\Employees\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employees extends Model
{
    use SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'name', 'cpf', 'gender', 'birth_date', 'email', 'phone', 'cell_phone', 'color', 'commission', 'is_access_system', 'observation'
    ];

    protected $dates = ['birth_date','deleted_at'];

    public static function optionSelect($employees = [])
    {
        $array = [];

        if(empty($employees))
            $employees = self::all();

        $employees->each(function ($item) use(&$array){
            $array[$item->id] = $item->name;
        });

        return $array;
    }


}
