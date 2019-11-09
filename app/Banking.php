<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banking extends Model
{

    protected $table = 'bank_treasur';
    public $timestamps = true;
    protected $fillable = [
        'id' , 'type', 'default','name', 'name_en', 'code','account','description', 'active','user_id', 'org_id',
    ];

}
