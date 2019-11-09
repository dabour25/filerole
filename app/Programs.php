<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    protected $connection = 'mysql2';
    protected $fillable = [
        'name', 'name_en','photo_id', 'description', 'image_id', 'active', 'sys_user_id'
    ];

    public $timestamps = true;

}
