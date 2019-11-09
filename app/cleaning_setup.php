<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class  cleaning_setup extends Model
{
    protected $table ='cleaning_setup';

    protected $fillable = [
      'property_id','cleaning_type','rank' ,'user_id','org_id','description'
    ];

    public $timestamps = true;


}
