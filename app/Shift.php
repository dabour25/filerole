<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{

    protected $table = 'shifts';
    protected $fillable = [
        'id',

        'name',
        'name_en',
        'org_id',
        'user_id',
    ];


    public $timestamps = true;


}
