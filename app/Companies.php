<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table = 'comp_supp';
    public $timestamps = true;
    protected $fillable = [
        'id' ,'name', 'name_en', 'phone','address','email', 'active','user_id', 'org_id'
    ];

}
