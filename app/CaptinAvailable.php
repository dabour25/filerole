<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaptinAvailable extends Model
{

    protected $table = 'captin_available';
    public $timestamps = true;
    protected $fillable = [
        'id' , 'day', 'time', 'active','captin_id', 'user_id', 'org_id',
    ];

}
