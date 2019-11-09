<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $fillable = [
        'cat_id', 'cust_id', 'book_type', 'book_from', 'book_to', 'mobile', 'email', 'adult_no', 'chiled_no', 'source_type', 'source_name', 'remarks', 'nights', 'book_status', 'payment_status', 'price', 'final_price', 'tax_id','tax_val','checkin_dt','confirmation_no','category_num_id', 'org_id', 'user_id'
    ];

    public $timestamps = true;
}

