<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locators extends Model
{
    protected $table = "locators";
    public $timestamps = true;
    protected $fillable = [
        'store_id','name', 'description', 'active', 'org_id', 'user_id'
    ];

}
