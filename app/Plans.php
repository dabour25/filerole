<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    //
    protected $connection = 'mysql2';
    protected $fillable = [
        'country_id', 'currency_id','category_name', 'category_desc', 'footer_comment', 'month_val', 'month_desc', 'month3_val', 'month3_desc', 'year_val', 'year_desc', 'customer_value', 'invoice_value', 'offer_value', 'emp_value', 'emp__over_price', 'active', 'sys_user_id'
    ];

    public $timestamps = true;

}
