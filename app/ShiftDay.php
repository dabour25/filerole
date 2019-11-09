<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShiftDay extends Model
{
  
    protected $table = 'shift_days';
    protected $fillable = [
        'id',
        'shift_id',
        'shift_day',
        'time_from',
        'time_to',
        'org_id',
        'user_id',
    ];


    public $timestamps = true;


}
