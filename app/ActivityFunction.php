<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityFunction extends Model
{
    protected $table = 'activity_functions';

    protected $fillable = [
        'id',
        'activity_id',
        'function_id',
        'created_by'
    ];
    public $timestamps = true;


}
