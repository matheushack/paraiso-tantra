<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 30/10/18
 * Time: 09:02
 */

namespace App\Models;


use App\Traits\OptionSelect;
use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    use OptionSelect;

    protected $table = 'banks';

    protected $fillable = [
        'id', 'name'
    ];
}