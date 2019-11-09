<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingDetails extends Model
{

    protected $table='booking_detail';

	 protected $fillable = [
        'book_id',
        'cat_id',
        'catsub_id',
        'cat_price',
        'cat_final_price',
        'tax',
        'tax_val',
        'category_num_id',
        'org_id',
        'user_id',
    ];
	public $timestamps = true;


}
