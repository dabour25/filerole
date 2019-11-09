<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPaymentDetail extends Model
{
    protected $table = "customer_payment_details";
    public $timestamps = true;
    protected $fillable = [
        'customer_payid',
        'customer_id',
        'first_name',
        'last_name',
        'email',
        'address',
        'city',
        'governorate',
        'country',
        'mobile',
        'zip',
    ];

}
