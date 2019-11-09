<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerMeasure extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cust_id', 'measure_id','measure_val', 'org_id', 'active', 'user_id', 'remarks', 'date'
    ];
    public $timestamps = true;
    protected $table = 'customer_measure';

}
