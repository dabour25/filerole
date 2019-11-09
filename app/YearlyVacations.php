<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YearlyVacations extends Model
{
    protected $table = "year_vacation";
    public $timestamps = true;
    protected $fillable = [
        'name', 'name_en','date', 'year', 'description','active', 'org_id', 'user_id'
    ];

}
