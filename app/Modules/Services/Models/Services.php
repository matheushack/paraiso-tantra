<?php

namespace App\Modules\Services\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use SoftDeletes;

    protected $table = 'services';

    protected $fillable = [
        'name', 'description', 'amount', 'discount', 'duration', 'is_active'
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
