<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeeklyVacations extends Model
{
    protected $table = "week_vacation";
    public $timestamps = true;
    protected $fillable = [
        'name', 'active', 'org_id', 'user_id'
    ];

}
