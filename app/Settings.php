<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
     protected $fillable = [
        'key' , 'value', 'user_id', 'org_id',
    ];

    public $timestamps = true;
}
