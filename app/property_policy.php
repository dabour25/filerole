<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class property_policy extends Model
{
    protected $table ='property_policy';

    protected $fillable = [
        'details', 'details_en','policy_type_id', 'org_id', 'user_id','property_id','cat_id'
    ];
     public $timestamps = true;

}
