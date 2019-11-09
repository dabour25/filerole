<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalcSalary extends Model
{
    protected $table = 'calc_sal';
    public $timestamps = true;

    protected $fillable = [
        'sal_date', 'sal_mon', 'sal_year', 'Sal_flag_closed', 'active', 'org_id', 'user_id',
    ];


}
