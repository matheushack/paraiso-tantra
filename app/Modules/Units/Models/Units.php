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
