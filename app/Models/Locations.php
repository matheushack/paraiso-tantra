<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 05/10/18
 * Time: 12:22
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Locations  extends Model
{
    /**
     * @var string
     */
    protected $table = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cep', 'address', 'neighborhood', 'city', 'state'
    ];
}