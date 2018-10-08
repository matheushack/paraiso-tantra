<?php

namespace App\Modules\Services\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model {

    protected $table = 'services';

    protected $fillable = [
        'name', 'description', 'amount', 'discount', 'duration', 'is_active'
    ];

    public static function optionSelect()
    {
        $array = [
            '' => 'Selecione'
        ];
        $units = self::all();
        $units->each(function ($item) use(&$array){
            $array[$item->id] = $item->name;
        });

        return $array;
    }

}
