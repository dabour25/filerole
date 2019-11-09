<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FunctionsUser extends Model
{

    
    protected $table='functions_user';
    protected $fillable = [
        'id' ,
        'user_id',
        'org_id',
        'functions_id',
        'funcname',
        'funcname_en',
        'technical_name',
        'funcparent_id',
        'technical_name',
        'parent_id',
        'porder',
        'appear',
        'font',
        'created_by',
        'func_name'
    ];
    public $timestamps = true;


}
