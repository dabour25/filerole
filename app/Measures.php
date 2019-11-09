<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measures extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'name_en','description', 'org_id', 'active', 'user_id'
    ];
    public $timestamps = true;
    protected $table = 'measure_type';

}
