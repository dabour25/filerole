<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FunctionActivity extends Model
{
     protected $connection="mysql2";
    protected $table = 'functions_activity';

    protected $fillable = [
        'id',
        'activity_id',
        'function_id',
        'funcname',
        'funcname_en',
        'description',
        'description_en',
        'technical_name',
        'type',
        'funcparent_id',
        'free',
        'font',
        'appear',
        'porder',
        'func_name'
    ];
    


}
