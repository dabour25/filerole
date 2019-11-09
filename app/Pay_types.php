<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay_types extends Model
{
    protected $fillable = [
       'name', 'name_en','code', 'type', 'basic', 'loan', 'active', 'org_id', 'user_id',
    ];
    public $timestamps = true;

    

    


}
