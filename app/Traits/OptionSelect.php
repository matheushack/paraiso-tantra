<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 30/10/18
 * Time: 08:34
 */

namespace App\Traits;


trait OptionSelect
{
    public static function optionSelect($options = [], $id = 'id', $name = 'name')
    {
        if(empty($options))
            $options = self::all();

        $options->each(function ($item) use(&$array, $id, $name){
            $array[$item->$id] = $item->$name;
        });

        return $array;
    }
}