<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 04/02/19
 * Time: 16:27
 */

namespace App\Modules\Bills\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Providers extends Model
{
    use SoftDeletes;

    protected $table = 'providers';

    protected $fillable = [
        'name', 'phone', 'cell_phone'
    ];
}