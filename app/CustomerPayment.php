<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    protected $table = "customer_payments";
    public $timestamps = true;
    protected $fillable = [
        'external_req_id',
        'customer_id',
        'org_id',
        'payment_date',
        'payment_tot',
        'currency_id',
        'pay_gateway',
        'card_owner_name',
        'card_no',
        'check_code',
        'card_exp_date',
        'transaction_id',
    ];

}
