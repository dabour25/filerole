<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emp_pay_types extends Model
{
    protected $fillable = [
       'pay_type_id', 'emp_val','val_date', 'type', 'emp_id', 'active', 'org_id', 'user_id',
    ];
    public $timestamps = true;

    

    


}
