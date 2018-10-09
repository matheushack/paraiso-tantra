<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 08/10/18
 * Time: 14:50
 */

namespace App\Modules\Calls\Models;


use Illuminate\Database\Eloquent\Model;

class CallEmployees extends Model
{
    protected $table = 'call_employees';

    public $timestamps = false;

    protected $fillable = [
        'call_id', 'employee_id'
    ];

    public function calls()
    {
        return $this->hasMany(Calls::class, 'id', 'call_id');
    }
}