<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $table = "stores";
    public $timestamps = true;
    protected $fillable = [
        'name', 'name_en', 'description', 'active', 'org_id', 'user_id'
    ];

}
