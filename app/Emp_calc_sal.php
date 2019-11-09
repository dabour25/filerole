<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emp_calc_sal extends Model
{
  protected $table = 'emp_calc_sal';

    protected $fillable = [
       'emp_id',
       'pay_type_id',
       'sal_type_val',
       'description',
       'sal_date',
       'sal_mon',
       'sal_year',
       'days',
       'sal_flag_closed',
       'org_id',
       'user_id'
    ];
    public $timestamps = true;






}
