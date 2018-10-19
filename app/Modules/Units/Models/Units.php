<?php

namespace App\Modules\Units\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Units extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'units';

    protected $fillable = [
        'cnpj', 'name', 'social_name', 'cep', 'address', 'number', 'complement', 'neighborhood', 'city', 'state', 'email', 'phone', 'cell_phone', 'operating_hours'
    ];

    protected $dates = ['deleted_at'];

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
