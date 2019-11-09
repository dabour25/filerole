<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterMeasures extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection="mysql2";
     protected $table = 'measure_type';
    protected $fillable = [
        'name', 'name_en','description', 'activity_id', 'active', 'sys_user_id'
    ];
    public $timestamps = true;


}
