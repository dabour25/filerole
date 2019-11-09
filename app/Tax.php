<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'tax_setup';
    public $timestamps = true;
    protected $fillable = [
        'name', 'name_en','description', 'percent', 'value', 'active', 'org_id', 'user_id',
    ];


}
