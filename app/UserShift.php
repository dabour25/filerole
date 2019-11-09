<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserShift extends Model
{
  
    protected $table = 'user_shifts';
    protected $fillable = [
        'id',
        'captin_id',
        'shift_id',
        'org_id',
        'user_id',
    ];


    public $timestamps = true;


}
