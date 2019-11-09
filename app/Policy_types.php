<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Policy_types extends Model
{
    protected $table ='policy_type';

    protected $fillable = [
        'name', 'name_en','type', 'org_id', 'user_id'
    ];
     public $timestamps = true;

}
