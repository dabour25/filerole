<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $table='bookings';

	 protected $fillable = [
        'cust_id',
        'book_type',
        'book_from',
        'book_to',
        'mobile',
        'email',
        'adult_no',
        'chiled_no',
        'source_type',
        'source_name',
        'remarks',
        'nights',
        'book_status',
        'payment_status',
        'final_price',
        'checkin_dt',
        'org_id',
        'user_id'


    ];
	public $timestamps = true;


}
